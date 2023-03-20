<?php
class MainController extends Controller{
    public function index(){
        //On ouvre la session pour accéder à la superglobale $_SESSION
        session_start();
        //Si l'utilisateur est connecté (donc si on a défini $_SESSION['id_connected_user'] dans le LoginController)
        if(isset($_SESSION['id_connected_user'])){
            //On récupère tous les posts de notre base de données
            $postsDb = Post::findAll();
            //Je reproduis ma base de donnée en objets directement
            //Pour chaque ligne renvoyée par ma requête SELECT * FROM post, je crée un nouveau Post
            for($i=0 ; $i<count($postsDb) ; $i++){
                new Post($postsDb[$i]['id'],$postsDb[$i]['Title'],$postsDb[$i]['Content'],$postsDb[$i]['User_idUser']);
            }
            //Si l'utilisateur a cliqué sur un input de type submit sur ma page
            $request = $_SERVER["REQUEST_METHOD"];
            if($request === "POST"){
                try{
                    //On crée un objet de type Post (les erreurs seront gérés directement dans les setters de la classe)
                    //Pour l'id, on compte le nombre de lignes que nous a renvoyé le Post::findAll() et on enlève 1 pour récupérer la dernière valeur du tableau, on peut ensuite obtenir son id grâce à sa clé ["id"]
                    $post = new Post($postsDb[count($postsDb)-1]["id"] + 1, $_POST["title"], $_POST["content"], $_SESSION['id_connected_user']);
                    //On insère notre poste dans la base de données
                    $post->insertIntoDb();
                }
                catch(Exception $e){
                    die($e->getMessage());
                }
            }
            $posts = Post::getPosts();
            //On récupère l'utilisateur connecté
            $userFromDb = User::findById($_SESSION['id_connected_user'])[0];
            //On crée l'objet qui lui correspond
            $user = new User($userFromDb["id"],$userFromDb["username"],$userFromDb["password"],$userFromDb["firstName"],$userFromDb["lastName"]);
            //On affiche la vue, elle aura accès à toutes les variables créées plus tôt dans le Controller (donc $user, $posts, ...)
            require(__DIR__ . "/../../views/main.php");
        }
        else{
            //S'il n'y a pas d'utilisateur connecté, on le renvoie sur la page login
            $this->redirect('/login');
        }
    }
}
?>