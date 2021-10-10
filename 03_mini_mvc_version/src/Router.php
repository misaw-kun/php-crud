<?php 
    namespace app;

    class Router {

        public array $getRoutes = [];
        public array $postRoutes = [];
        public Database $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function get($url, $fn) 
        {
            $this->getRoutes[$url] = $fn;
        }

        public function post($url, $fn)
        {
            $this->postRoutes[$url] = $fn;

        }

        public function resolve()
        {
            // we need the path_info key (if not present use root)
            // NOTE: path_info only exists in php's local server and not in apache virtual hosts
            // instead we use the REQUEST_URI(which contains the query strings also)
            // $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
            $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
            if (strpos($currentUrl, '?') !== false) {
                $currentUrl = substr($currentUrl, 0, strpos($currentUrl, '?'));
            }

            $method = $_SERVER['REQUEST_METHOD'];

            if($method === 'GET') {
                $fn = $this->getRoutes[$currentUrl] ?? null;
            } else {
                $fn = $this->postRoutes[$currentUrl] ?? null;
            }

            if ($fn) {
                // echo '<pre>';
                // var_dump($fn);
                // echo '</pre>';
                call_user_func($fn, $this); //we are passing the router to the product_controller to call renderView method
            } else {
                echo "page not found";
            }
        }

        public function renderView($view, $params = [])
        {
            foreach($params as $key => $value) {
                $$key = $value;   //here we are making a variable out of the key paramater and assigning it a value (1st '$'for variable, 2nd '$' for the name which is picked up dynamically)
            }

            ob_start(); //caching the output to store it, include our partials then output it

            include_once __DIR__."/views/$view.php";
            $content = ob_get_clean();

            include_once __DIR__.'/views/_layout.php';
        }
    }
 ?>
