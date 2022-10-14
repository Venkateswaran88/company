<x-app-layout>
    <br/>
    @if($isAdmin)
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('resume.create') }}"> Add/Upload resumes</a>
                </div>
            </div>
            <br/>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        $(document).ready(function(){
            var currentRequest = null;
            $('input[name=search]').keyup(debounce(function() {
                var str = $(this).val();
                if (str.length >= 3 && str.length <= 20) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    currentRequest = $.ajax({
                        /* the route pointing to the post function */
                        url: '/search-resume',
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: {_token: CSRF_TOKEN, search:$(this).val()},
                        beforeSend : function()    {           
                            if(currentRequest != null) {
                                currentRequest.abort();
                            }
                        },
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) {
                            $("div#searchId").html(data);
                        }
                    });
                } else {
                    $("div#searchId").html('');
                }
            }, 500));
        });
        

        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };
    </script>

    <input type="text" name="search" placeholder="Search" id="searchId" class="form-controll">
    <br/><br/>
    <div id="searchId">
    </div>
</x-app-layout>