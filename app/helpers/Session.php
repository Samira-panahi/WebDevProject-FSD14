<?php
/**
 * @file
 * Session helper class for managing user sessions.
 */
class Session {

    /**
     * Starts the session if it's not already started.
     */
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Sets a value in the session.
     * @param string $key The key for the session variable.
     * @param mixed $value The value to set.
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Checks if a key exists in the session.
     * @param string $key The key to check.
     * @return bool True if the key exists, false otherwise.
     */
    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    /**
     * Gets a value from the session.
     * @param string $key The key for the session variable.
     * @return mixed The session value or null if not found.
     */
    public static function get($key) {
        return self::has($key) ? $_SESSION[$key] : null;
    }

    /**
     * Removes a key from the session.
     * @param string $key The key to remove.
     */
    public static function unset($key) {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroys the entire session.
     */
    public static function destroy() {
        session_unset();
        session_destroy();
    }

    /**
     * Sets a flash message in the session.
     * Flash messages are meant to be displayed once and then removed.
     * @param string $key The key for the flash message.
     * @param string $message The message to set.
     */
    public static function flash($key, $message) {
        self::set($key, $message);
    }
}
?>