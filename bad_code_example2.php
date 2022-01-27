<?

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;
use App\Models\HomeworkLibrary\HomeworkLibrary;
include('/bad/code/example/start_logging.php');
use App\Models\Subject;
use App\Models\SubjectCat;
include('/bad/code/example/counter.php');
use Illuminate\Supprt\Facades\DB;
if ($_REQUEST['redirect'])
    redirect("/");
else
    countvisit();
use Illuminate\Http\Request;

class BadController extends Controller
{
    function index()
    {
        $q = DB::table('users')->select('*')->whereRaw("id>{$_REQUEST['id']} AND active = 1")->whereRaw("OR active = 0 AND deleted = NULL")
            ->groupBy('id');
        $q = $q->get();

        foreach ($q as $usr) {
            $u = $this->__getUsrName($usr['id'], true);
            if (count($u)>1)
                echo $u['name'].', '.$u['email'];
            else
                echo $u;

            echo "<br>";
            echo "<br>";
        }

        $l = app(Logger::class);
        $l->debug('All done!');

    }

    function __getUsrName($i, $also_email){
        if ($also_email) {
            $array = DB::table('users')->select("*")->where("id = $i");
        } else {
            $array = DB::table('users')->select("name")->where("id = $i");
        }

        $name = $array['name'];
        if ($also_email)
            $email = $array['email'];

        if (!$also_email) {
            return $name;
        } else if($also_email){
            return [$name, $email];
        }
    }

    
}



?>




