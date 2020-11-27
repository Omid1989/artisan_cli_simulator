<?php


namespace artisan_cli\gui\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class ArtisanCliController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('ArtisanCLI::cli');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function runCli(Request $request)
    {
        if($request->command!=="queue:work" && $request->command!=="serve")
        {
            $output = new BufferedOutput();
            try
            {
                Artisan::call($request->command,[],$output);
                $output = $output->fetch();
            }
            catch (\Exception $exception)
            {
                $output = $exception->getMessage();
            }

            return response()->json(['output'=>$output,'command' => $request->command]);

        }
        else
        {
            return response()->json(['output'=>" The command $request->command does not support ",'command' => $request->command]);

        }
    }
}
