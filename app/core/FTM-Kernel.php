<?php

class FTM_Kernel {
    public function initialize(): void
    {
        $this->loadEnvironment();
        $this->registerAutoload();
        session_start();
    }

    private function loadEnvironment(): void
    {
        if (file_exists(__DIR__ . '/../../.env')) {
            $lines = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                putenv(trim($line));
            }
        }
    }

    private function registerAutoload() {
        spl_autoload_register(function ($class) {
            $paths = [
                __DIR__ . '/../classes/' . $class . '.php',
                __DIR__ . '/../controllers/' . $class . '.php',
                __DIR__ . '/../models/' . $class . '.php',
                __DIR__ . '/' . $class . '.php',
            ];
            foreach ($paths as $file) {
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }
}
