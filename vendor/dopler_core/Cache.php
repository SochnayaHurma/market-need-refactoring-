<?php 
namespace dopler_core;

class Cache
{
    use TSingleton;

    public function set(string $key, string|array|object $data, int $seconds = 3600): bool
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;

        if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
            return true;
        } else {
            return false;
        }
    }

    public function get(string $key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {

            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file);
        } else { 
            return false;
        }
    }

    public function delete(string $key): void
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {

            unlink($file);
        }
    }
}

?>