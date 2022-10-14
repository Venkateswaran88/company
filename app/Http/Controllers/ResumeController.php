<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Auth;
use File;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isAdmin = Auth::user()->isAdmin();
        return view('resume.index', compact(['isAdmin']));
    }

    public function searchResume(Request $request)
    {
        $request = $request->all();
        $results = [];
        $str = '';
        $resumes = Resume::latest();

        if (isset($request['search']) && !empty($request['search'])) {
            $str = $request['search'];
            $resumes->where('content', 'LIKE', '%' . $str. '%');
        }
        $resumes = $resumes->get();
        $results = $this->parseContent($str, $resumes);

        $response = '';
        if (count($results)) {
            $response = '<table class="table table-border">';
            foreach ($results as $result) {
                $response .= "<tr>
                <td>Name:". $result['name'] . "<td>
                <td>Filename:" . $result['filename'] . "<td>
                <td>Matches:" . $result['content'] . "<td></tr>";
            }
        }
        $response .='</table>';
        return $response;
    }

    private function parseContent($str, $resumes)
    {
        $result = [];
        foreach ($resumes as $resume) {
            $record['name'] = $resume->name;
            $record['filename'] = $resume->filename;
            $content = $resume->content;
            $match = [];
            if (!empty($str)) {
                while (stripos($content, $str) != false) {
                    $pos = stripos($content, $str);
                    $subStringStart = $pos < 30 ? 0 : $pos - 30;
                    $length = 60;
                    $match[] = substr($content,$subStringStart,$length);
                    $content = substr($content, $subStringStart+$length, strlen($content));
                }
            }            
            $record['content'] = implode("<br/>", $match);
            $result[] = $record;
        }
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        return view('resume.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }

        $request->validate([
            'resume.*' => 'required|mimes:txt,doc,docx'
        ]);
        if($request->hasFile('resume')) {
            $imageNameArr = [];
            foreach ($request->resume as $file) {
                // you can also use the original name
                $originalName = $file->getClientOriginalName();
                $name = pathinfo($originalName, PATHINFO_FILENAME);
                $filename = rand(1000,99999) . time().'-'. $originalName;
                $file->move(public_path('resumes'), $filename);
                $content = File::get(public_path('resumes'). '/' . $filename);

                $resume = new Resume;
                $resume->name = $name;
                $resume->filename = $filename;
                $resume->path = 'resumes';
                $resume->content = $content;
                $resume->save();
            }
        }

        return redirect()->route('resume.index')
                        ->with('success', 'Resume uploaded successfully.');
    }
}
