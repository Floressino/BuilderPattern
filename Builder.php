<? 

    require('Config.php');
    require('User.php');
    require('Director.php');

    interface iBuilder {

    }


    class BuilderForm implements iBuilder{
        public $user;

        public function form()
        {
            require('DataBase.php');

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];

            $user = $DB->GetUser($first_name, $last_name);

            if ($user == false){
                $message = "Пользователь не найден!";
                Director::SendMessage($message, true);
            } else {
                $this->user = new User($user['first_name'], $user['last_name']);
                return $this;
            }
        }
    }

    class BuilderVk implements iBuilder {
        public $user;

        public function vk()
        {
            include 'DataBase.php';

			$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id='.ID.'&redirect_uri='.URL.'&client_secret='.SECRET.'&code='.$_GET['code']), true);

			if (!$token) {
				exit('error token');
			}

			$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id='.$token['user_id'].'&access_token='.$token['access_token'].'&fields=first_name,last_name&v=5.131'), true);

			if (!$data) {
				exit('error data');
			}

			$first_name = $data['response'][0]['first_name'];
			$last_name = $data['response'][0]['last_name'];

            $user = $DB->getUser($first_name, $last_name);

            if (!is_array($user)){
                $user = $DB->addUser($first_name, $last_name);
                $this->user = new User($user['first_name'], $user['last_name']);
                return $this;
            } else {
                $this->user = new User($user['first_name'], $user['last_name']);
                return $this;
            }
        }
    }

    class BuilderDatabase implements iBuilder {
        public $user;

        public function dataBase()
        {
            require('DataBase.php');

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];

            if (empty($first_name) or empty($last_name)){
                $message = "Заполните все поля!";
                Director::SendMessage($message, true);
            } else if ($DB->getUser($first_name, $last_name) != false) {
                $message = "Пользователь с данными существует!";
                Director::SendMessage($message, true);
            } else {
                $this->user = $DB->addUser($first_name, $last_name);
                return $this;
            }
        }
    }

    $director = new Director();

	$builderVk = new BuilderVk();
    $builderForm = new BuilderForm(); 
    $builderDatabase = new BuilderDatabase();
	
    if (isset($_POST['EnterAccountWithVk'])) {
        include 'Config.php';
        header("Location: https://oauth.vk.com/authorize?client_id=".ID."&display=page&redirect_uri=".URL."&response_type=code");
    } elseif (isset($_POST['RegAccount'])) {
        $director->setBuilder($builderDatabase);
        $director->builder->dataBase();
    } elseif (isset($_POST['EnterAccount'])) {
        $director->setBuilder($builderForm);
        $director->builder->form();
    } elseif ($_GET['code']) {
        $director->setBuilder($builderVk);
        $director->builder->vk();
    }

    $director->userFind($director->builder->user);
?>