<?php

namespace App\Http\Controllers;

use App\Models\Complete;
use App\Models\EnrolLesson;
use App\Models\EnrolModule;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Avatar;
use App\models\User;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\answer;
use App\Models\Attempt;
use App\Models\Stamp;
use App\Models\Video;
use App\Models\Enroll;
use Auth;

class userController extends Controller
{
		public function landingPage()
		{
				return view('landingPage');
		}
		public function splandingPage()
		{
				return view('splandingPage');
		}
		public function signin()
		{
				return view('signin');
		}
		public function splogin()
		{
				return view('log_in');
		}
		public function dashboard()
		{
			$enroll = Enroll:: where('user_id', Auth::id())->get();
			$courses = Course::get();
			return view('user.dashboard')->with('courses',$courses)->with('enroll',$enroll);
			//return view('user.video-test')->with('courses',$courses)->with('enroll',$enroll);
		}
		public function spdashboard()
		{
			$enroll = Enroll:: where('user_id', Auth::id())->get();
			$courses = Course::get();
			return view('user.spdashboard')->with('courses',$courses)->with('enroll',$enroll);
		}
		public function achivement()
		{
				$enroll = Enroll::where('user_id', Auth::id())->get();
				return view('user.achivement')->with('enroll',$enroll);
		}
		public function grade()
		{
				$attempt = attempt::get();
				return view('user.grade')->with('attempt',$attempt);
		}
		public function certificate()
		{
				return view('user.certificate');
		}
		public function topics($id)
		{
				$quiz = quiz::where('course_id',$id)->get();
				return view('user.topics')->with('quiz',$quiz);
		}
		public function video(Request $request, $id)
		{
            // $next_less = '';
            // dd($id);
//				$course = Course::where('id',$id)->first();
//                $videos = Video::where('course_id',$id)->get();
//				$video = Video::where('course_id',$id)->first();
//				$stamps = Stamp::where('video_id',$id)->get();
//				return view('user.video')->with('course',$course)->with('quiz',$quiz)->with('videos',$videos)->with('video',$video)->with('stamps',$stamps);

            $enrols = Enroll::where('user_id',auth()->id())->get();
            if ($request->lesson_id){
                $less = Lesson::where('id',$request->lesson_id)->first();
            }else{
                $less = Lesson::where('course_id',$id)->first();
            }
            $next_less = Lesson::where('id','>',$less->id)->where('module_id',$less->module_id)->first();
            // $next_less = Lesson::where('id','>',$less->id)->first();


            $this->updateEnrolLessonStatus($less->id);


            //dd($lesson);
            //$quizzes = Quiz::where('course_id',$id)->get();

            return view('user.video-load',compact('enrols','less','next_less'));
		}

        // public function updateEnrolLessonStatus(Request $request){
        //     //dd($request->lesson_id);

        //     if ($request->lesson_id){

        //         $alreadyCompleted = Complete::where('user_id',auth()->id())->where('lesson_id',$request->lesson_id)->first();

        //         //dd($alreadyCompleted);
        //         if ($alreadyCompleted == null){
        //             Complete::create([
        //                 'lesson_id'=>$request->lesson_id,
        //                 'user_id'=>auth()->id(),
        //             ]);
        //         }

        //         return response()->json('saved',200);
        //     }
        // }
        public function updateEnrolLessonStatus($id){
            //dd($request->lesson_id);

            if ($id){

                $alreadyCompleted = Complete::where('user_id',auth()->id())->where('lesson_id',$id)->first();

                //dd($alreadyCompleted);
                if ($alreadyCompleted == null){
                    Complete::create([
                        'lesson_id'=>$id,
                        'user_id'=>auth()->id(),
                    ]);
                }

                return response()->json('saved',200);
            }
        }
		public function userquiz($id)
		{
                $next_quiz = Quiz::where('id','>',$id)->first();
                $prev_quiz = Quiz::where('id','<',$id)->first();

				$quiz = Quiz::where('id',$id)->get();
				$quizs = Quiz::where('id',$id)->first();
                $module = $quizs->module;
                // dd($modules);
				$course = Course::where('id' , $quizs->course->id )->first();
				$attempt = Attempt::where('course_id',$quizs->course->id)->where('quiz_id',$id)->where('user_id',Auth::user()->id)->first();
				return view('user.userquiz')->with('attempt',$attempt)->with('course',$course)->with('quiz',$quiz)->with('id',$id)->with('module',$module)->with('next_quiz',$next_quiz)->with('prev_quiz',$prev_quiz);
		}
		public function quiztest($id)
		{
				$questions = Question::where('quiz_id',$id)->get();
				$quiz = Quiz::where('id',$id)->first();
				$course = Course::where('id' , $quiz->course->id )->first();
				return view('user.quiztest')->with('questions',$questions)->with('quiz_id',$id)->with('quiz',$quiz)->with('course',$course);
		}
		public function quizresult(Request $request)
		{
				$quiz = Quiz::where('id',$request->quiz_id)->first();
				$totalmarks=0;
				$rightanswer=0;
				$count = count($quiz->questions);
				foreach($quiz->questions as $q)
				{
						if($q->corrent_ans==implode($request->ans))
							{
								$rightanswer=$rightanswer+1;
							}
							else
							{
								// $totalnumber;
							}
				}
				$percentage = ($rightanswer/$count)*100;
				$attempt = Attempt::where('user_id',Auth::user()->id)->where('course_id',$quiz->course->id)->where('quiz_id',$request->quiz_id)->first();
				if($attempt)
				{
					$attempt->attempt =  $attempt->attempt+1;
					$attempt->result = $percentage;
					$attempt->save();
				}else{
					$attempt = new Attempt();
					$attempt->user_id = Auth::user()->id;
					$attempt->course_id = $quiz->course->id;
					$attempt->quiz_id = $request->quiz_id;
					$attempt->result = $percentage;
					$attempt->attempt = 1;
					$attempt->save();
				}
				$quizes = Quiz::where('id',$quiz->id)->get();
				$quiz = Quiz::where('id',$quiz->id)->first();
				$course = Course::where('id' , $quiz->course->id )->first();

				$complete = 0;
				$enrolls = Enroll::where('user_id',Auth::user()->id)->get();
				foreach($enrolls as $enroll)
				{
					$course = Course::where('id',$enroll->course_id)->first();
					$quizs = Quiz::where('course_id',$course->id)->get();
					$quizcount = $quizs->count();
					foreach($quizs as $quiz)
					{
						$attempts = Attempt::where('course_id',$course->id)->get();
						$attemptcount = $attempts->count();
						if($attemptcount == $quizcount)
						{
							foreach($attempts as $attempt)
							{
								$at = $attempt->result;
								if($at > 80)
								{
									$complete = 1;
								}
								else{
									$complete = 2;
									break;
								}
							}
						}
						else
						{
							$complete = 0;
						}
					}
					$enroll = Enroll::where('user_id',Auth::user()->id)->where('course_id',$course->id)->first();
					$enroll->complete = $complete;
					$enroll->save();
				}
				return view('user.quizresult')->with('attempt',$attempt)->with('course',$course)->with('quizes',$quizes)->with('id',$quiz->id);
		}

		public function profile($id)
		{
				$user= User::where('id',$id)->first();
				return view('user.profile',['user' => $user]);
		}
		public function edit_profile(Request $request)
		{
				$user = User::where('id',$request->id)->first();
				// $user->firstname = $request->firstname;
				// $user->lastname = $request->lastname;
				// if($request->password)
				// {
				// 		$user->password = Hash::make($request->password);
				// }
				// $user->save();

				if ($request->hasFile('useravatar')) {
						$avatar =  Avatar::where('user_id',$request->id)->first();
						$file = $request->file('useravatar');
						$extension = $file->getClientOriginalExtension(); // getting image extension
						$filename = time().'.'.$extension;
						$file->move('assets/images/user/img/', $filename);
						$avatar->src = $filename;
						$avatar->save();
				}
				return redirect('/user/dashboard');
		}
}
