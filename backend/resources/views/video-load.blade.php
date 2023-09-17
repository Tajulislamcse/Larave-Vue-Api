@include('layouts.header')
<div class="d-flex flex-column" style="height: 100vh;">
    @include('layouts.navbar2')

    <!--Main Body Starts-->
    <div class="d-flex container-fluid py-5 py-md-0 px-md-0 flex-grow-1" style="background-color: #F0F4F9;">
        <div class="d-flex flex-column container-fluid flex-grow-1">
            <div class="row d-flex flex-grow-1">
                <!--Left Side Column -->
                <div class="d-flex px-md-0 mx-auto col-12 col-md-3 ">
                    <div class="d-flex flex-column flex-grow-1 mx-auto col-12">
                        <div class="card flex-column flex-grow-1"  style="border-radius: 0px;">
                          
                            @if($enrols->count() > 0)
                                @foreach($enrols as $enrol)
                                    <div class="d-flex flex-column flex-grow-1 pt-xl-3 px-3 px-xxl-5 border-start-0 border-bottom-0 border-start-0" style="border-radius: 0px;">
                                        <h5 class="ps-2 py-2 border-bottom mb-0">{{$enrol->course->title}}</h5>

                                        @if($enrol->course->modules->count() > 0)
                                            @foreach($enrol->course->modules as $module)
                                                <div class="accordion mt-2" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$module->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                                {{$module->title}}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse-{{$module->id}}" class="accordion-collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body p-0">
                                                                @if($module->lessons->count() > 0)
                                                                    <ul class="mb-0 ic__webDevelopment p-0">
                                                                        @foreach ($module->lessons as $lesson)
                                                                        <li class="lesion-list relative">
                                                                            <a href="{{route('video',['id' => $enrol->course->id,'lesson_id'=>$lesson->id])}}" class="text-decoration-none">
                                                                                <h6 class="mb-0"><i value='' id='time'   class="far fa-play-circle"></i>
                                                                                    {{$lesson->title}}
                                                                                </h6>
                                                                            </a>
                                                                            
                                                                            @if(!\App\Models\Complete::checkCompleteOrNot($enrol->course_id,$module->id,$lesson->id))
                                                                               
                                                                                <div class="ic-list-overlay d-flex justify-content-end align-items-center">
                                                                                    <i class="bi bi-lock-fill text-danger"></i>
                                                                                </div>
                                                                            @endif
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>

                                                                       {{-- <a onclick="videochange('{{$lesson->lesson_element}}')" class="text-decoration-none">
                                                                           <h6><i value='' id='time'   class="far fa-play-circle"></i>
                                                                               {{$lesson->title}}
                                                                           </h6>
                                                                      </a> --}}


                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($module->quizzes->count() > 0)
                                                    <div class="accordion mt-2" id="QuizAccordionExample-{{$module->id}}">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-Quiz-{{$module->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                                    Quizzes
                                                                </button>
                                                            </h2>
                                                            <div id="collapse-Quiz-{{$module->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#QuizAccordionExample-{{$module->id}}">
                                                                <div class="accordion-body p-0">
                                                                    <ul class="mb-0 ic__webDevelopment p-0">
                                                                        @foreach ($module->quizzes as $quiz)
                                                                        <li class="lesion-list relative">
                                                                            <a  href="{{ route('userquiz',['id'=> $quiz->id]) }}"  class="text-decoration-none">
                                                                                <h6><i class="fa-regular fa-clipboard"></i>
                                                                                    Quiz # {{$quiz->title}}
                                                                                </h6>
                                                                            </a>
                                                                            @if(!\App\Models\Quiz::checkAllLessonCompleteOrNot($quiz->course_id,$module->id))
                                                                                    <div class="ic-list-overlay d-flex justify-content-end align-items-center">
                                                                                        <i class="bi bi-lock-fill text-danger"></i>
                                                                                    </div>
                                                                            @endif

                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                </div>
                                            @endforeach
                                        @endif



                                        <div>
                                            <div class="pt-2">
                                                {{-- <h5 class="py-2 ps-2" for="course_name">
                                                    Topic 01
                                                </h5> --}}
                                                <div class="ps-4 pt-2">
                                                    {{--                                            <div class="ps-4" style="border-left: 2px solid #DDDDDD;">--}}
{{--                                                                                                    @foreach ($videos as $v)--}}
{{--                                                                                                    <a onclick="videochange('{{$v->src}}')" class="text-decoration-none">--}}
{{--                                                                                                        <h6><i value='' id='time'   class="far fa-play-circle"></i> --}}
{{--                                                                                                          {{$v->title}}--}}
{{--                                                                                                        </h6>--}}
{{--                                                                                                    </a>--}}
{{--                                                                                                    @endforeach--}}
{{--                                                                                                    @foreach ($quiz as $q)   --}}
{{--                                                                                                            <a  href="{{ route('userquiz',['id'=> $q->id]) }}"  class="text-decoration-none">--}}
{{--                                                                                                                <h6><i class="fa-regular fa-clipboard"></i>--}}
{{--                                                                                                                    Quiz # {{$q->title}}--}}
{{--                                                                                                                </h6>--}}
{{--                                                                                                            </a>--}}
{{--                                                                                                    @endforeach--}}
                                                    {{--                                            </div>   --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!--Right Side Column -->
                <div class="px-md-0 ps-3 col-md-9 mt-4 mt-md-0 border-start-0 d-flex flex-grow-1">
                    <div class="card w-100 p-4 border-end-0 border-bottom-0 border-start-0 d-flex flex-grow-1" style="border-radius: 0px;">
                        <div class="container-fluid px-0 px-sm-3">
                        <div class="d-flex flex-wrap justify-content-between pb-2 px-2">
                            <div class="pe-sm-5">
{{--                                <h4 class="py-2 mb-0 fw-normal h4_Course">{{$course->title}} > Video 01</h4>--}}
                                <h4 class="py-2 mb-0 fw-normal h4_Course text-capitalize"> <span id="lesson_title"></span></h4>
                            </div>
                            {{-- <div class="d-flex justify-content-end" >
                                <button class="btn me-2 btn_Pre_nxt"  type="submit"><i class="fa-solid fa-less-than"></i> &nbsp; Previous</button>
                                <button class="btn btn_Pre_nxt"  type="submit"> Next &nbsp; <i class="fa-solid fa-greater-than"></i></button>
                            </div>   --}}
                        </div>
                            <div class="row">
                                <div class="col-12 mx-auto">
                                    <div id="content-box">
                                        @if(!empty($less))
                                            @if($less->lesson_type == 'link')
                                                <div class="mb-3" id="lesson_element">
                                                    <div style="padding:56.25% 0 0 0;position:relative;">
                                                        <iframe id="video_player" src="{{$less->lesson_element}}&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="LMS introduction">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            @elseif ($less->lesson_type == 'file')
                                                <div class="mb-3" id="lesson_element">
                                                    <div>
                                                        <iframe src="{{ URL::asset('assets/course/lessons/'.$less->lesson_element) }}" width="100%" height="350px"></iframe>
                                                    </div>
                                                    
                                                </div>
                                            @endif
                                                 @if($next_less)
                                                    <div class="d-flex justify-content-end mt-3">
                                                        {{-- <button id="complete_lesson" class="btn btn-outline-success"  type="submit">Complete</button> --}}
                                                        <a id="complete_lesson" class="btn btn-outline-success"  href="{{route('video',['id' => $enrol->course->id,'lesson_id'=>$next_less->id])}}">Next Lesson</a>

                                                    </div>
                                                    @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Main Body Ends-->

        <!--Pop-UP Modal -->
        <div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="instructionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="instructionLabel">Completed</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-3">
                            <div class="text-center">
                                <h5>Completed Lesson Successfully</h5>
                                <p>Click next to unlock next</p>
                                <button id="nextButton" class="btn btn-success btn-sm">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
	{{--function videochange(link) {--}}
	{{--	var video = document.getElementById("videotest");--}}
	{{--	video.src='{{ URL::asset('assets/course/video/') }}' + "/"+link;--}}
	{{--}--}}
{{--    function videoChange(id,course_id,module_id,title,lesson_type,lesson_element) {--}}

{{--        $('#lesson_title').text(title)--}}
{{--        $('#lesson_element').remove()--}}
{{--        if(lesson_type == 'link'){--}}
{{--            $('#content-box').append(`--}}
{{--        <div class="mb-3" id="lesson_element">--}}
{{--                                                                    <div style="padding:56.25% 0 0 0;position:relative;">--}}
{{--                                                                        <iframe id="video_player" src="${lesson_element}&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="LMS introduction">--}}

{{--                                                                        </iframe>--}}
{{--                                                                    </div></div>`)--}}


{{--            var iframe = document.getElementById('video_player');--}}
{{--            var player = new Vimeo.Player(iframe);--}}
{{--            player.getEnded().then(function(ended) {--}}
{{--                console.log(ended)--}}

{{--                if(ended){--}}

{{--                    $.ajax({--}}
{{--                        type: 'post',--}}
{{--                        url: '{{route('updateEnrolLessonStatus')}}',--}}
{{--                        data: {'lesson_id': id},--}}
{{--                        dataType: 'json',//return data will be json--}}
{{--                        success: function (data) {--}}

{{--                        },--}}
{{--                        error: function (error) {--}}
{{--                            console.log(error)--}}
{{--                        }--}}
{{--                    });--}}


{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        if(lesson_type == 'file'){--}}

{{--            $('#content-box').append(`<div class="mb-3" id="lesson_element">--}}
{{--<div>--}}
{{--                                                                        <iframe src="http://lms-group-one-usa.test/assets/course/lessons/${lesson_element}" width="100%" height="350px">--}}
{{--                                                                        </iframe>--}}
{{--                                                                    </div>--}}
{{--</div>`)--}}
{{--        }--}}
{{--    }--}}

</script>

<script>
    //var iframe = document.querySelector('iframe');
    // var iframe = document.getElementById('video_player');
    // console.log(iframe)
    // var player = new Vimeo.Player(iframe);
    // player.getEnded().then(function(ended) {
    //     console.log('end')
    // });
    function updateLessonStatus(lesson_id){
        if(lesson_id != null){
                $.ajax({
                    type: 'post',
                    url: '{{route('updateEnrolLessonStatus')}}',
                    data: {'lesson_id': lesson_id},
                    dataType: 'json',//return data will be json
                    success: function (data) {
                        console.log('lesson status changed');
                        // $("#completeModal").modal('show');

                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);
    let lesson_id = {{@$less->id}};

    // player.on('play', function() {
    //     alert('You have played the video')
    // });
    player.on('ended', function(ended){
        //alert('Video play completed');

        if(ended.percent == 1){
            //console.log(ended.percent);
            console.log(lesson_id);

            updateLessonStatus(lesson_id);



        }
    });

    // player.getVideoTitle().then(function(title) {
    //     console.log('title:', title);
    // });
</script>
<script>
    $(document).ready(function(){
        $('#nextButton').on('click',function () {
            $("#completeModal").modal('hide');
            window.location.reload()
        })

        // $('#complete_lesson').on('click',function () {
        //     let lesson_id = {{@$less->id}};
        //     updateLessonStatus(lesson_id);
        //     // console.log('tajul')
        // })
    });
</script>

<style>
    .ic__webDevelopment li {
        list-style: none;
        position: relative;
        padding: 10px 20px;
    }
    .ic-list-overlay {
        position: absolute;
        top: 0;
        width: 100%;
        left: 0;
        background: #ffffff5c;
        height: 100%;
        padding: 10px;
    }
    .ic-list-overlay p{
        font-size: 12px;
        color: red;
    }
    .ic-list-overlay i{
        font-size: 12px;
    }
    .lock-accordion{
        pointer-events: none;
    }
    .btn_complete{

    }
</style>

