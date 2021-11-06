<?

    class Director {

        public $builder;

        public function setBuilder(iBuilder $builder): void
        {
            $this->builder = $builder;
        }

        public static function sendMessage($message, $isRedirect){
            echo '<script type="text/javascript">',
                "alert('{$message}');",
                "if ({$isRedirect}) {location='http://BuilderPattern'}",
                '</script>';
        }

        public static function userFind($user){
            $message = "Пользователь найден!";
            Director::sendMessage($message, false);
            echo "<b>Имя: {$user->first_name}</b><br>",
                "<b>Фамилия: {$user->last_name}</b><br>",
                "<a href='http://BuilderPattern'>Вернуться назад</a>";
        }
    }

?>