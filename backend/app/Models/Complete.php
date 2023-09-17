<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complete extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','lesson_id'];
    // public static function checkCompleteOrNot($course_id,$module_id,$lesson_id)
    // {
    //     $firstLesson = Lesson::where('course_id',$course_id)->first();
    //     if ($firstLesson->id == $lesson_id){
    //         return true;
    //     }else{
    //         $completed = Complete::where('user_id',auth()->id())->where('lesson_id',$lesson_id)->first();
    //         if ($completed != null){
    //             return true;
    //         }else{

    //             $previous_complete_lesson = Complete::where('user_id', auth()->id())->where('lesson_id', '<', $lesson_id)->orderBy('id','desc')->first();
    //             if ($previous_complete_lesson != null)
    //             {
    //                 $next_lesson = Lesson::where('id', '>', $previous_complete_lesson->lesson_id)->orderBy('id')->first();

    //                 if ($next_lesson != null)
    //                 {
    //                     if ($next_lesson->id == $lesson_id)
    //                     {
    //                         return true;
    //                     }
    //                     else
    //                     {
    //                         return false;
    //                     }
    //                 }
    //                 else
    //                 {
    //                     return false;
    //                 }
    //             }
    //             else
    //             {
    //                 return false;
    //             }
    //         }
    //     }
    // }
    public static function checkCompleteOrNot($course_id,$module_id,$lesson_id)
    {
        $firstLesson = Lesson::where('course_id',$course_id)->first();
        $completed = Complete::where('user_id',auth()->id())->where('lesson_id',$lesson_id)->first();

        if ($firstLesson->id == $lesson_id || $completed != null)
        {
            return true;
        }
        else
        {
            $module = Module::where('course_id',$course_id)->where('id','<',$module_id)->first();
            if($module)
            {
                $quizzes = $module->quizzes;
                $sum  = 0;
                foreach($quizzes as $quizz)
                {
                    $attempt = Attempt::where('user_id',auth()->id())->where('course_id',$course_id)->where('quiz_id',$quizz->id)->first();
                    if($attempt)
                    {
                        $sum += $attempt->result;
                    }

                }
                $avg = $sum / $quizzes->count();
                if($avg >= 80)
                {
                    return true;
                }
                else
                 return false;
            }
            // $completed = Complete::where('user_id',auth()->id())->where('lesson_id',$lesson_id)->first();
            // if ($completed != null){
            //     return true;
            // }else{

                // $previous_complete_lesson = Complete::where('user_id', auth()->id())->where('lesson_id', '<', $lesson_id)->orderBy('id','desc')->first();
                // if ($previous_complete_lesson != null)
                // {
                //     $next_lesson = Lesson::where('id', '>', $previous_complete_lesson->lesson_id)->orderBy('id')->first();

                //     if ($next_lesson != null)
                //     {
                //         if ($next_lesson->id == $lesson_id)
                //         {
                //             return true;
                //         }
                //         else
                //         {
                //             return false;
                //         }
                //     }
                //     else
                //     {
                //         return false;
                //     }
                // }
                // else
                // {
                //     return false;
                // }
            
        }
    }
//   public static function checkCompleteOrNot($course_id,$module_id,$lesson_id)
//     {
//         $firstLesson = Lesson::where('course_id',$course_id)->first();
//         $completed = Complete::where('user_id',auth()->id())->where('lesson_id',$lesson_id)->first();
//         $previous_complete_lesson = Complete::where('user_id', auth()->id())->where('lesson_id', '<', $lesson_id)->orderBy('id','desc')->first();
//         if($previous_complete_lesson != null)
//         {
//           $next_lesson = Lesson::where('id', '>', $previous_complete_lesson->lesson_id)->orderBy('id')->first();
//         //   dd($next_lesson->id);
           
//         }


//         if ($firstLesson->id == $lesson_id || $completed != null || ($previous_complete_lesson != null && $next_lesson = null)){
//             return true;
//         }else{
//             return false;
           
//         }
        
    // }


}
