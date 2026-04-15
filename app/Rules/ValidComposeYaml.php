<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Log;
use Symfony\Component\Yaml\Yaml;

class ValidComposeYaml implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        Log::info($value);
        // Try parsing YAML
        try {
            $yaml = Yaml::parse($value);
        } catch (\Exception $e) {
            $fail('The :attribute field contains invalid YAML.');
            return;
        }

        // Ensure "services" exists
        if (!isset($yaml['services']) || !is_array($yaml['services']) || count($yaml['services']) === 0) {
            $fail('The YAML must contain at least one service.');
            return;
        }

        foreach ($yaml['services'] as $name => $service) {
            if (!isset($service['image']) && !isset($service['build'])) {
                $fail("Service '{$name}' must have either an image or build directive.");
                return;
            }
        }
    }
}
