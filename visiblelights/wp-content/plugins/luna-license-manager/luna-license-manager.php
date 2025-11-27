        // Call OpenAI API with GPT-5.1 primary and GPT-4o fallback
        $payload_base = array(

        $models = array('gpt-5.1', 'gpt-4o');
        $response_content = null;

        foreach ($models as $model_index => $model) {
            $payload = $payload_base;
            $payload['model'] = $model;

            $response = wp_remote_post('https://api.openai.com/v1/chat/completions', array(
                'timeout' => 60,
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $api_key,
                ),
                'body' => wp_json_encode($payload),
            ));

            if (is_wp_error($response)) {
                error_log('[VL Hub] OpenAI request failed for snapshot summary using ' . $model . ': ' . $response->get_error_message());
                continue;
            }

            $status = (int) wp_remote_retrieve_response_code($response);
            $raw_body = wp_remote_retrieve_body($response);

            if ($status >= 400) {
                error_log('[VL Hub] OpenAI HTTP ' . $status . ' for snapshot summary using ' . $model . ': ' . substr($raw_body, 0, 500));
                continue;
            }

            $body = json_decode($raw_body, true);
            if (isset($body['choices'][0]['message']['content'])) {
                if ($model_index > 0) {
                    error_log('[VL Hub] Fallback to ' . $model . ' succeeded for snapshot summary');
                }
                $response_content = $body['choices'][0]['message']['content'];
                break;
            }

            error_log('[VL Hub] Invalid OpenAI response format for snapshot summary using ' . $model);

        return $response_content;
