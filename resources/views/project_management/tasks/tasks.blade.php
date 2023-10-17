<h5 class="status">

    {{ $taskName }} complete </h5>

@foreach ($tasks as $task)
    <div class="task">
        <!-- Display task details here -->
        @if ($task->status == 'completed')
            <a href="#" class="task-uncomplete-link"><i class="fa-solid fa-circle-check"
                    data-task-id="{{ $task->id }}"></i></a>
        @else
            <a href="#" class="task-complete-link"><i class="fa-regular fa-circle-check"
                    data-task-id="{{ $task->id }}"></i></a>
        @endif
        {{-- {{ $task->id }} --}}
        {{ $task->subject }}
        @if (!empty($task->start_date))
            {{ ' ' . $task->start_date . ' ' }}To{{ ' ' . $task->due_date . ' ' }}
        @endif
        <div class="icons">

            <i class="fa-regular fa-calendar clndr"></i>

            <a href="#" class="task-view-link"><i class="fa-regular fa-eye"
                    data-task-id="{{ $task->id }}"></i></a>

            {{-- <div class="tab_content">
            <div class="tab_c" data-step="1" style="">
                <ul data-prjct_id="1">
                    <li class="edit_prjct"><i class="fa-solid fa-pen"></i> Edit project Details</li>
                    <li class="disabled"><i class="fa-regular fa-copy"></i> Copy</li>
                    <li class="disabled"><i class="fa-solid fa-briefcase"></i> Save as Template</li>
                    <li class="disabled"><i class="fa-solid fa-box-archive"></i> Archive</li>
                    <li class="disabled"><i class="fa-solid fa-plus"></i> More options</li>
                    <li class="delete"><i class="fa-solid fa-trash"></i> Delete</li>
                </ul>

            </div>

            <div class="tab_C" style="display: none;">
                <ul data-prjct_id="1">
                    <li class="disabled"><i class="fa-regular fa-square-check"></i> Add task</li>
                    <li class="disabled"><i class="fa-solid fa-chart-line"></i> Add budget</li>
                    <li class="add_users"><i class="fa-regular fa-user"></i> Add user</li>
                    <li class="disabled"><i class="fa-solid fa-envelope"></i> Add message</li>
                </ul>
            </div>
        </div> --}}
            <div class="tdropdown">
                {{-- <button class=" " type="button"> --}}
                <i class="fa-solid fa-ellipsis tellipsisBtn" onclick="myFunction(this)"></i>
                {{-- </button> --}}
                <div class="tdropdown-content">
                    <ul>
                        <li id="edit-task" class="edit-task-option" data-task-id="{{ $task->id }}">
                            <i class="fa-solid fa-pencil option_list_icon edit-task"></i>
                            <span class="option_list_text">Edit </span>
                        </li>

                        <br>

                        <li class="disabled"><i class="fa-regular fa-copy option_list_icon "></i> <span
                                class="">copy </span></li>
                        <br>
                        <li class="disabled"><i class="fa-solid fa-sort option_list_icon"></i> <span
                                class="option_list_text">Reorder </span></li>
                        <br>
                        <li class="disabled"><i class="fa-solid fa-file option_list_icon"></i> <span
                                class="option_list_text">Reports</span></li>
                        <br>
                        <li class="delete-btn" data-task-id="{{ $task->id }}">

                            <i class="fa-solid fa-trash option_list_icon"></i>Delete
                        </li>

                    </ul>
                </div>
            </div>
            <br>
        </div>
    </div>
@endforeach
<div class="task-detail-container"></div>


<div class="edit-form-container"></div>

<div id="container">

</div>

{{-- <a href="#"><i class="fa-solid fa-plus text-blue trigger-link"data-task-list="{{ $task->task_list_id }}"></i>add a task</a> --}}
<script>
    //menu
    window.onclick = function(event) {
        if (!event.target.matches('.tellipsisBtn')) {
            //  var crntTask = $(this).data('tsk-id');
            //console.log("tl",crntTask);
            var tdropdowns = document.getElementsByClassName("tdropdown-content");
            var i;
            for (i = 0; i < tdropdowns.length; i++) {
                var opentdropdown = tdropdowns[i];
                if (opentdropdown.classList.contains('show')) {
                    opentdropdown.classList.remove('show');
                }
            }
            //$("#delete-task").attr("data-tsks-id", '1')
        }
    }

    //task details
    $(document).ready(function() {
        $('.task-view-link').click(function(event) {
            event.preventDefault();
            var taskId = $(this).find('i').data('task-id');
            var taskDetailContainer = $(this).closest('.tasks_container');

            if (taskDetailContainer.length === 0) {
                taskDetailContainer = $('<div class="tasks_container"></div>');
                $(this).closest('.tasks_container').append(taskDetailContainer);
            }

            $.ajax({
                url: '/tasks/' + taskId + '/view',
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "GET"
                },
                success: function(data) {
                    taskDetailContainer.html(data);

                    // Add something to the URL without reloading the page
                    var newUrl = '/tasks/' + taskId + '/view';
                    window.history.pushState({
                        path: newUrl
                    }, '', newUrl);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });


    //task completion trigger 
    $(document).ready(function() {
        $('.task-complete-link').click(function(event) {
            event.preventDefault();
            var taskId = $(this).find('i').data('task-id');

            $.ajax({

                url: '/tasks/' + taskId + '/complete',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT"
                },
                success: function(response) {
                    // Update the UI to show that the task is complete
                    alert('Task Completed');
                    // $('#myElement').removeClass('original-class').addClass('new-class');
                    //$(event.target).addClass('completed');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });



    //task Uncompletion trigger 
    $(document).ready(function() {
        $('.task-uncomplete-link').click(function(event) {
            event.preventDefault();
            var taskId = $(this).find('i').data('task-id');

            $.ajax({

                url: '/tasks/' + taskId + '/uncomplete',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT"
                },
                success: function(response) {
                    // Update the UI to show that the task is complete
                    alert('Task status set to uncomplete');
                    // $('#myElement').removeClass('original-class').addClass('new-class');
                    //$(event.target).addClass('completed');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

    // edit task form call
    const editTaskForm = `

    <form action="#" class="edit_task_form"  id="my-great-drop" data-task-id="" enctype="multipart/form-data">

@csrf
@method('post')

            <div class="add_task">
            <div class="">
    <input type="hidden" name="pro_id" value="">
    <input type="text" name="subject" placeholder="what needs to be done?" required="required">
             </div>

                <div class="task_bar">
                    <ul>
                        <li class="active">
                            <i class="fa-regular fa-square-check"></i> Task
                            Details
                        </li>
                        <li><i class="fa-solid fa-paperclip"></i> Files</li>
                        <li><i class="fa-regular fa-flag"></i> Priority</li>
                        <li>
                            <i class="fa-regular fa-clock"></i> Progress & Time
                        </li>
                        <li><i class="fa-regular fa-eye"></i> Followers</li>
                        <li><i class="fa-solid fa-tag"></i> Tags</li>
                        <li><i class="fa-solid fa-plus"></i> More</li>
                    </ul>
                </div>

                <div class="task_content">
                    <div class="task_tab active">
                        <div class="input_group">
                            <div class="input">
                                <label for="doer">Who Should do this?</label>
                                <select name="doer" id="doer">
                                    <option value="1">Mubashir Rehman</option>
                                </select>
                            </div>

                            <div class="input">
                                <label for="st_date">Start Date</label>
                                <input
                                    type="date"
                                    name="st_date"
                                    id="st_date"
                                />
                            </div>

                            <div class="input">
                                <label for="due_date">Due Date</label>
                                <input
                                    type="date"
                                    name="due_date"
                                    id="due_date"
                                />
                            </div>
                        </div>

                        <div class="textarea" style="width: 100%">
                            <label for="description"
                                >Provide a detailed description for this task
                                (optional)</label
                            >
                            <textarea
                                name="notes"
                                id="notes"
                                cols=""
                                rows="5"
                                placeholder="Add a description"
                                style="width: 100%"
                            ></textarea>
                        </div>
                    </div>

                    <div class="task_tab">
                        <div class="input">
                            <label for="files" style="margin-bottom: 10px"
                                >Would you like to attach files to this
                                task?</label
                            >
                            <div class="attach_files_cont">
                                <div id="attached_files_con" >
                                    Drop or paste files here
                                </div>
                                <div>
                                    <label class="custom-file-button">
                                        <input
                                            type="file"
                                            id="attch_file" name="file"
                                            class="hidden-input"
                                            multiple
                                        />
                                        <span>+ Add Files</span>
                                    </label>
                                    <button
                                        type="button"
                                        class="existing_files custom-file-button"
                                    >
                                        Select from Existing Files
                                    </button>
                                    <div id="dropped_files"></div>
                                    </div>
                                    </div>

                            </div>
                        </div>
                    </div>

                    <div class="task_tab">
                        <div class="input">
                            <label for="priority"
                                >Chose the priority of this task</label
                            >
                            <div class="radio">
                                <input
                                    type="radio"
                                    name="priority"
                                    value="None"
                                    id="priority"
                                    label="None "
                                    checked="true"
                                />
                                <input
                                    type="radio"
                                    name="priority"
                                    value="Low"
                                    id="priority"
                                    label="Low"
                                />
                                <input
                                    type="radio"
                                    name="priority"
                                    value="Medium"
                                    id="priority"
                                    label="Medium"
                                />
                                <input
                                    type="radio"
                                    name="priority"
                                    value="High"
                                    id="priority"
                                    label="High"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="task_tab">
                        <div class="input_group" style="max-width: 550px">
                            <div class="input">
                                <label for="progress"
                                    >Progress so for (0%)</label
                                >
                                <input
                                    type="range"
                                    name="progress"
                                    id="progress"
                                />
                            </div>

                            <div class="input">
                                <label for="est_time"
                                    >Esitmated time to complete</label
                                >
                                <div
                                    style="
                                        display: flex;
                                        max-width: 165px;
                                        gap: 10px;
                                    "
                                >
                                    <label>
                                        <input
                                            type="number"
                                            name="hours"
                                            id="hours"
                                            style="padding: 5px"
                                        />
                                        h
                                    </label>
                                    <label>
                                        <input
                                            type="number"
                                            name="minutes"
                                            id="minutes"
                                            style="padding: 5px"
                                        />
                                        m
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                </div>
            </div>
            <input  class="submit-btn" type="submit" value="update">
            OR
            <button class="cancel" id="form-cancel">cancel</button>
        </form>

`;






    // task form call
    // edit task form call
    $("body").on("click", '.edit-task-option', function() {
        var editFormContainer = $(this).closest('.task').find('.edit-form-container');
        var taskId = $(this).data('task-id');
        console.log(taskId);

        // Check if the edit form already exists
        if (editFormContainer.length === 0) {
            editFormContainer = $('<div class="edit-form-container"></div>');
            $(this).closest('.task').append(editFormContainer);
        }

        // Toggle the visibility of the form
        editFormContainer.toggle();

        editFormContainer.html(editTaskForm);
        $("#my-great-drop").attr("data-task-id", taskId);
    });


    // task form call
    $("body").on("click", '.cancel', function() {

        $("body .task_form").remove()


    }); // <!-- add task form js  
    $(document).ready(function() {
        $("#notes").summernote({
            placeholder: "Add Your Description here...",
            tabsize: 2,
            height: 100,
            // airMode: true,
            toolbar: [
                // ['style', ['style']],
                [
                    "font",
                    [
                        "bold",
                        "italic",
                        "strikethrough",
                    ],
                ],
                ["para", ["ul", "ol"]],
                ["insert", ["link", "picture", "video"]],
                ["view", ["undo", "redo"]], // ['fullscreen', 'codeview', 'help']
            ],
            // toolbar: [
            //     // ['style', ['style']],
            //     [
            //         "font",
            //         [
            //             "bold",
            //             "underline",
            //             "clear",
            //             "fontname",
            //             "fontsize",
            //             "forecolor",
            //             "backcolor",
            //             "italic",
            //             "strikethrough",
            //             "superscript",
            //             "subscript",
            //         ],
            //     ],
            //     ["color", ["color"]],
            //     ["para", ["ul", "ol", "paragraph", "style", "height"]],
            //     ["table", ["table"]],
            //     ["insert", ["link", "picture", "video"]],
            //     ["view", ["codeview", "help", "undo", "redo"]], // ['fullscreen', 'codeview', 'help']
            // ],

        });

        // Switch Tabs
        $("body").on("click", ".task_bar ul li", function() {
            var tabs = $(this).index();
            $(this).parent().find(".active").removeClass("active");
            $(this).addClass("active");

            // if($(this).parents().eq(1).next().hasClass('task_content')){
            //     var tab = $(this).parent().next()
            // } else {
            var tab = $(this).parents().eq(1).next();
            // }

            tab.find(".task_tab").each(function(index) {
                if (index == tabs) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });


        $('body').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });

        $('body').on('dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });

        $('body').on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var files = e.originalEvent.dataTransfer.files;
            $('#attch_file')[0].files = files;
            $(this).removeClass('dragover');
            displayDroppedFiles(files);
        });

        function displayDroppedFiles(files) {
            var droppedFilesContainer = $('#dropped_files');
            droppedFilesContainer.empty(); // Clear previous dropped files

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var fileName = file.name;
                var fileType = file.type;
                var fileIcon = '';

                if (fileType.includes('image')) {
                    fileIcon = '<img src="image_icon_url" alt="' + fileName + '" style="width: 50px;">';
                } else if (fileType.includes('pdf')) {
                    fileIcon = '<img src="pdf_icon_url" alt="' + fileName + '" style="width: 50px;">';
                } else {
                    fileIcon = '<img src="generic_icon_url" alt="' + fileName + '" style="width: 50px;">';
                }

                droppedFilesContainer.append(fileIcon + '<span>' + fileName + '</span><br>');
            }
        }
    });
    //edit task form submition
    $(document).ready(function() {
        $('body').on('click', '.submit-btn', function(e) {
            e.preventDefault();

            var formData = new FormData($('.edit_task_form')[0]); // Get form data
            var taskId = $('#my-great-drop').data('task-id'); // Get the data-task-list-id from the form
            console.log(taskId);
            var url = "{{ route('update.task', ['taskId' => ':taskId']) }}";
            url = url.replace(':taskId', taskId);

            // Append the URL to the formData object
            formData.append('_method', 'PUT'); // Add the PUT method override

            $.ajax({
                type: 'POST',
                url: url, // Use the constructed URL
                data: formData, // Use the form data
                contentType: false,
                processData: false,
                success: function(response) {
                    // Update the UI to show that the task is complete
                    $("body .edit_task_form").remove()
                    alert('success');
                    //$(event.target).addClass('completed');
                },
                error: function(error) {
                    // Handle error (optional)
                    console.error('Error updating data:', error);
                }
            });
        });
    });



    //DELETING TASK
    $(document).ready(function() {
        $('body').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var taskId = $(this).data('task-id');

            $.ajax({
                type: 'DELETE',
                url: '/delete/' + taskId,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    // Handle success
                    alert('Task deleted successfully');
                },
                error: function(error) {
                    // Handle error
                    console.error('Error deleting task:', error);
                }
            });
        });
    });
</script>

<style>
    /* .details {
    width: 60%;
    height: 100%; /* Adjust as needed
    background-color: #f2f2f2; /* Add background color for visibility
}
*/
    /* .tasks { */
    /* width: 100%; /* Adjust as needed  */
    /* background-color: #e6e6e6; /* Add background color for visibility  */
    }

    .heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .buttons {
        display: flex;
        align-items: center;
    }

    .listItem {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .listItemContent {
        display: inline-block;
        margin-right: 10px;
        /* Adjust as needed */
    }

    .btn_con ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .btn_con li {
        padding: 8px 16px;
        cursor: pointer;
    }

    .btn_con {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: none;
        /* Initially hide the menu */
        min-width: 150px;
    }

    .tellipsisBtn {
        background: none;
        border: none;
        cursor: pointer;
    }

    .listItem:hover .btn_con {
        display: block;
    }


    /* tdropdown */
    /* tdropdown Button */
    .dropbtn {
        background-color: #3498DB;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* tdropdown button on hover & focus */
    .dropbtn:hover,
    .dropbtn:focus {
        background-color: #2980B9;
    }

    /* The container <div> - needed to position the dropdown content */
    .tdropdown {
        position: relative;
        display: inline-block;
        text-align: left;
        /* border: 1px solid #ccc; */
        border-radius: 8px;
        background-color: white;
        padding: 0%;
        /* padding: 10px; */
    }

    /* Dropdown Content (Hidden by Default) */
    .tdropdown-content {
        text-align: left !important;
        display: none;
        position: absolute;
        background-color: white;

        min-width: 200px;
        border-radius: 8px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s, transform 0.3s;
    }

    /* Links inside the dropdown */
    .tdropdown-content a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left !important;
        transition: background-color 0.3s, color 0.3s;
    }


    .tdropdown-content ul li {
        float: none;
        /* Remove float */
        width: 100%;
        /* Remove fixed width */
        display: inline-block;
        /* Display as inline-block */
        list-style: none;
        text-align: left;
        padding: 0;
    }

    .tdropdown-content .fa-trash {
        color: red;
    }

    /* Add padding to icons */
    .tdropdown-content ul li i {
        /* margin-right: 10px; */
    }

    /* Change color of dropdown links on hover */
    .tdropdown-content li:hover {
        background-color: #f0f0f0;
    }

    /* Show the dropdown menu with fade-in effect */
    .show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }


    .task {
        /* Use 'font-weight' instead of 'font:bold;' */
        /* text-decoration:none; */
        width: 100%;
        margin-left: 5%;
        /* width: 500px; */
        color: gray;
        text-decoration-style: none;
    }

    .status {
        margin-left: 5%;

    }

    .tasks a:hover {

        text-decoration: none;
    }

    .task:hover {

        text-decoration: none;
        background-color: white;
        /* Use 'background-color' instead of 'background-coolor' */

    }

    .task .icons {
        display: none;
        /* Hide the icons by default */
    }

    .task:hover .icons {
        display: inline-block;
        /* Show the icons on hover and keep them on the same line */
        flex: 5;
    }

    /* .task .special-icon {
    display: none; /* Hide the icons by default */
    }

    /* .task:hover .special-icon {
    display: inline-block; /* Show the icons on hover and keep them on the same line */
    }

    */ */ .task {
        position: relative;
        left: 2;
    }

    .icons {
        position: relative;
    }

    .icon {
        display: none;
        /* Hide icons by default */
        /* Add any other styling you need for your icons */
    }

    .special-icon {
        /* position: absolute; */
        right: 0;
        /* Position at the very end of the container */
        display: inline-block;
        /* Display the special icon */
    }

    .task:hover .icons .icon {
        display: inline-block;
        /* Show icons on hover */
    }

    .add:hover {
        background-color: #f2f4fc;
        /* Use 'background-color' instead of 'background-coolor' */
    }




    /* //hover on eye */




    .hover-link {
        display: none;
        position: absolute;
        top: 100%;
        /* Position below the eye icon */
        left: 50%;
        /* Centered relative to the icon container */
        transform: translateX(-50%);
        /* Center horizontally */
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 2px;
        padding: 5px;
        font-size: 14px;
        text-decoration: none;
    }

    .icons .hover-link {
        display: inline-block;
    }


    /* EDIT TASK FORM  */


    .task_bar ul {
        display: flex;
        gap: 5px;
        margin-bottom: 0;
    }

    .task_bar ul li {
        list-style: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .task_bar ul li.active {
        background-color: #f2f4fc;
    }

    .task_content {
        background-color: #f2f4fc;
        margin-top: 0;
        padding: 10px;
    }

    .task_content .dropzone {
        border: none;
    }

    .task_tab {
        display: none;
    }

    .task_tab.active {
        display: block;
    }

    .dz-default {
        display: none;
    }

    label {
        font-size: 12px;
        font-weight: 400;
    }

    .attach_files_cont {
        background-color: #fff;
        padding: 10px 25px;
    }

    .radio {
        display: flex;
        gap: 5px;
        background-color: #fff;
        width: 100%;
        padding: 10px 15px;
    }

    input#priority {
        padding: 5px 10px;
        margin-left: 0 !important;
        width: fit-content;
    }

    .custom-file-button {
        display: inline-block;
        padding: 8px 16px;
        border: 1px solid #0056b3;
        color: #0056b3;
        border-radius: 4px;
        cursor: pointer !important;
        transition: background-color 0.3s ease;
        font-weight: 400;
        background-color: transparent;
    }

    .custom-file-button:hover {
        background-color: #f2f4fc;
    }

    .custom-file-button span {
        cursor: pointer !important;
    }

    .hidden-input {
        display: none !important;
    }

    .dragover {
        border: dashed 2.5px #dadada;
    }

    .deleteFile {
        color: #c20000;
        background-color: transparent;
        border-radius: 50%;
        padding: 5px 8px;
        border: 1px solid #f2f4fc;
    }

    .deleteFile:hover {
        border: 1px solid #0056b3;
        color: #0056b3;
    }

    .dz-preview {
        display: none;
    }

    .attachedFilePrev {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        border: none;
    }

    span.file_name {
        padding: 0 7px;
    }

    span.progress_prct {
        border-right: 1px solid #dadada;
        padding: 0 5px;
    }

    .submit-btn {
        background-color: blue;
        width: 20%;
        color: blue;
    }

    .listItemContent {
        font-size: large;
        font: bold;
    }
</style>
