<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <style>
        .draggable { padding: 10px; border: 1px solid #ccc; margin: 10px 0; cursor: move; }
        .droppable { min-height: 200px; border: 2px dashed #ccc; padding: 10px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Drag and Drop Form Builder</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="draggable" data-type="text">Text Input</div>
                <div class="draggable" data-type="textarea">Textarea</div>
                <div class="draggable" data-type="select">Select Box</div>
            </div>
            <div class="col-md-8">
                <div id="form-builder" class="droppable"></div>
                <button id="save-form" class="btn btn-primary mt-3">Save Form</button>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $(".draggable").draggable({
                helper: "clone"
            });

            $("#form-builder").droppable({
                accept: ".draggable",
                drop: function(event, ui) {
                    var type = ui.helper.data('type');
                    addField(type);
                }
            });

            function addField(type) {
                var field = {};
                switch(type) {
                    case 'text':
                        field = { type: 'text', label: 'Text Input' };
                        $("#form-builder").append('<div class="mb-3"><label>Text Input</label><input type="text" class="form-control"></div>');
                        break;
                    case 'textarea':
                        field = { type: 'textarea', label: 'Textarea' };
                        $("#form-builder").append('<div class="mb-3"><label>Textarea</label><textarea class="form-control"></textarea></div>');
                        break;
                    case 'select':
                        field = { type: 'select', label: 'Select Box', options: ['Option 1', 'Option 2'] };
                        $("#form-builder").append('<div class="mb-3"><label>Select Box</label><select class="form-control"><option>Option 1</option><option>Option 2</option></select></div>');
                        break;
                }
                $("#form-builder").data('fields', ($("#form-builder").data('fields') || []).concat([field]));
            }

            $("#save-form").click(function() {
                var fields = $("#form-builder").data('fields') || [];
                var formName = prompt("Enter the form name:");
                if (formName && fields.length > 0) {
                    $.ajax({
                        url: '{{ route("save.form") }}',
                        method: 'POST',
                        data: {
                            name: formName,
                            structure: JSON.stringify(fields),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert('Form saved successfully!');
                        }
                    });
                } else {
                    alert('Please add some fields and provide a name for the form.');
                }
            });
        });
    </script>
</body>

</html>
