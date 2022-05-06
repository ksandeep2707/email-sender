<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<!--start::Head-->
<head>
    <meta charset="utf-8" />
    <title>Content | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<!--end::Head-->

<!--begin::Body-->

<body class="header-fixed subheader-enabled page-loading">


    <div class="container mt-4">
        <!-- For alert Message -->
        <div class="alert {{Session::has('error')?(Session('error')?'alert-danger':'alert-success'):''}}" id='alert_msg'>
            {{Session::has('error')?Session('message'):''}}
        </div>
        <!-- End For alert Message -->

        <!-- Topic add section -->
        <div class="row">
            <h4 for="topic">Topic</h4>
            <form action="/add/topic" method='POST' class="form-inline">
                @csrf
                <div class="form-group">
                    <label for="formGroupExampleInput">Topic title</label>
                    <input type="text" class="form-control" name='topic' id="formGroupExampleInput" value="{{Request::old('topic')??''}}" placeholder="Topic title">
                    @error('topic')
                    <span class="text-danger mt-1" role="alert">
                        <strong>{{ $message }}</strong></span>
                    @enderror

                </div>
                <div class="form-group mt-4 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary"> Add Topic</button>
                </div>

            </form>
        </div>
        <!--End Topic add section -->


        <!-- User add section -->
        <div class="container mt-4">
            <h4 for="user">User</h4>
            <form action="/add/user" method='POST' class="form-inline">
                @csrf
                <div class="form-group">
                    <label for="formGroupExampleInput">User Email</label>
                    <input type="text" name='email' class="form-control" id="formGroupExampleInput" placeholder="User Email">
                    @error('email')
                    <span class="text-danger mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <div class="form-group mt-4">
                    <label for="formGroupExampleInput2">Subscribed Topic </label>
                    <select class="form-control" name='user_topic'>
                        <option selected>Choose Topic</option>
                        @foreach($topic as $item)
                        <option value="{{$item->id}}">{{ucfirst(strtolower($item->topic))}}</option>
                        @endforeach
                    </select>

                    @error('user_topic')
                    <span class="text-danger mt-1" role="alert">
                        <strong>{{ $message }}</strong></span>
                    @enderror


                </div>

                <div class="form-group mt-4 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary"> Add User</button>
                </div>

            </form>

        </div>
        <!--End User add section -->

        <!-- Content add section -->
        <div class="container mt-4">
            <h4 for="content">Content</h4>

            <div class="form-group">
                <label for="formGroupExampleInput">Content Description</label>
                <input type="text" class="form-control" name='description' id="formGroupExampleInput" placeholder="Content Description">

                @error('description')
                <span class="text-danger mt-1" role="alert">
                    <strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group mt-4">
                <label for="formGroupExampleInput2">Time</label>
                <input type="datetime-local" class="form-control" name='time' id="formGroupExampleInput2" placeholder="Content">

                @error('time')
                <span class="text-danger mt-1" role="alert">
                    <strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label for="formGroupExampleInput2">Topic</label>
                <select class="form-control" name='content_topic' id="content_topic">
                    <option value='' selected>Choose topic</option>

                    @foreach($topic as $item)
                    <option value="{{$item->id}}">{{ucfirst(strtolower($item->topic))}}</option>
                    @endforeach
                </select>

            </div>

            <div class="form-group mt-4 d-flex justify-content-center">
                <button class="btn btn-primary" onclick="saveContent()"> Add Content</button>
            </div>



        </div>
        <!-- End Content add section -->

    </div>

</body>
<!--end::Body-->

<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    /**
     * Function for sending email
     */
    function sendmail(content, content_topic, time) {

        /**
         * Ajax request for sending email
         *
         * @method POST
         * @params - content (longText) 
         *           content_topic (integer)
         *           time (datetime)
         */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token']").attr('value')
            }
        });

        $.ajax({
            type: "POST",
            url: "/send/mail",
            data: {
                "content": content,
                'content_topic': content_topic,
                'time': time,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                alert(response.message)


            }
        });
    }

    /**
     * Save Content data function 
     *
     */

    function saveContent() {

        let content = $("input[name='description']");
        let content_topic = $("#content_topic");
        let time = $("input[name='time']");

        $('#alert_msg').removeClass('alert alert-danger');
        $('#alert_msg').text('');

        content.removeClass('is-invalid');
        content_topic.removeClass('is-invalid');
        time.removeClass('is-invalid');

        let isvalid = true;

        /**
         * Validation through javascript
         *
         */
        if ($("input[name='description']").val() == '' || $("#content_topic").val() == '' || $("input[name='time']").val() == '') {
            $('#alert_msg').addClass('alert alert-danger');
            $('#alert_msg').text('Fill all the required filled');

            if (content.val() == '') {
                content.addClass('is-invalid');
            }

            if (content_topic.val() == '') {
                content_topic.addClass('is-invalid');
            }
            if (time.val() == '') {
                time.addClass('is-invalid');
            }
            console.log(content_topic.val());
            isvalid = false;
        }

        if (isvalid) {

            /**
             * Ajax request for saving Content
             *
             * @method POST
             * @params - content (longText) 
             *           content_topic (integer)
             *           time (datetime)
             */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").attr('value')
                }
            });



            $.ajax({
                type: "POST",
                url: "/add/content",
                data: {
                    "content": content.val(),
                    'content_topic': content_topic.val(),
                    'time': time.val(),
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    if (response.error) {
                        $('#alert_msg').addClass('alert alert-danger');
                        $('#alert_msg').text(response.message);
                    } else {

                        $('#alert_msg').addClass('alert alert-success');
                        $('#alert_msg').text(response.message);

                        /**
                         * setTimeout function calls sendMail function at the specified time selected by the admin 
                         *
                         */

                        setTimeout(sendmail(content.val(), content_topic.val(), time.val()), response.time_diff * 60 * 1000);
                    }
                }
            });
        }


    }
</script>


</html>