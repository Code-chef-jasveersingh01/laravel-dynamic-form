@extends('layout.app')
@section('content')

<div class="row">
    <div class="col-md-2">
        <div class="draggable p-2 border mb-3 bg-light" data-type="text">Text Input</div>
        <div class="draggable p-2 border mb-3 bg-light" data-type="textarea">Textarea</div>
        <div class="draggable p-2 border mb-3 bg-light" data-type="select">Select Box</div>
        <div class="draggable p-2 border mb-3 bg-light" data-type="radio">Radio Button</div>
        <div class="draggable p-2 border mb-3 bg-light" data-type="checkbox">Checkbox</div>
        <div class="draggable p-2 border mb-3 bg-light" data-type="button">Button</div>
    </div>
    <div class="col-md-10">
        <div id="form-builder" class="droppable"></div>
        <button id="save-form" class="btn btn-primary mt-3">Save Form</button>
    </div>
</div>

@endsection
@section('scripts')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <script>
    $(function() {
        function formatString(input) {
            // Convert to lowercase, trim, and replace spaces with underscores
            var formattedString = $.trim(input.toLowerCase()).replace(/\s+/g, '_');
            return formattedString;
        }

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
            var label, options, inputType;
            var field = {};

            switch(type) {
                case 'text':
                    label = prompt("Enter the label for this Text Input:");
                    if (!label) return;
                    inputName = formatString(label);
                    inputType = prompt("Enter the input type (e.g., text, email, number, password):");
                    if (!inputType) return;
                    field = { type: inputType, label: label, inputType: inputType ,inputName: inputName};
                    $("#form-builder").append('<div class="mb-3"><label>' + label + '</label><input name="' + inputName + '" type="' + inputType + '" class="form-control"></div>');
                    break;

                case 'textarea':
                    label = prompt("Enter the label for this Textarea:");
                    if (!label) return;
                    inputName = formatString(label);
                    inputType = prompt("Enter the input type (e.g., text, email, number, password):");
                    if (!inputType) return;
                    field = { type: 'textarea', label: label, inputType: inputType ,inputName: inputName};
                    $("#form-builder").append('<div class="mb-3"><label>' + label + '</label><textarea class="form-control" name="' + inputName + '" type="' + inputType + '"></textarea></div>');
                    break;

                case 'select':
                    label = prompt("Enter the label for this Select Box:");
                    if (!label) return;
                    inputName = formatString(label);
                    options = prompt("Enter options for the Select Box, separated by comma (text1:value1,text2:value2)");
                    if (!options) return;
                    var optionPairs = options.split(',').map(option => {
                        var pair = option.split(':');
                        return { text: pair[0].trim(), value: pair[1].trim() };
                    });
                    field = { type: 'select', label: label, options: optionPairs ,inputName: inputName};
                    var selectOptions = optionPairs.map(option => '<option value="' + option.value + '">' + option.text + '</option>').join('');
                    $("#form-builder").append('<div class="mb-3"><label>' + label + '</label><select name="' + inputName + '" class="form-control">' + selectOptions + '</select></div>');
                    break;

                case 'radio':
                    label = prompt("Enter the label for this Radio Button Group:");
                    if (!label) return;
                    inputName = formatString(label);
                    options = prompt("Enter options for the Radio Button Group, separated by commas:");
                    if (!options) return;
                    var radioPairs = options.split(',').map(option => {
                        var pair = option.split(':');
                        return { text: pair[0].trim(), value: pair[1].trim() };
                    });
                    field = { type: 'radio', label: label, options: radioPairs ,inputName: inputName};
                    var radioButtons = radioPairs.map(option => '<div class="form-check"><input name="' + inputName + '" type="radio" name="radio_' + label + '" value="' + option.value + '" class="form-check-input"><label class="form-check-label">' + option.text + '</label></div>').join('');
                    $("#form-builder").append('<div class="mb-3"><label>' + label + '</label>' + radioButtons + '</div>');
                    break;


                case 'checkbox':
                    label = prompt("Enter the label for this Checkbox:");
                    if (!label) return;
                    inputName = formatString(label);
                    field = { type: 'checkbox', label: label ,inputName: inputName};
                    $("#form-builder").append('<div class="mb-3"><label><input type="checkbox" name="' + inputName + '" class="form-check-input">' + label + '</label></div>');
                    break;

                case 'button':
                    label = prompt("Enter the label for this Button:");
                    if (!label) return;
                    field = { type: 'button', label: label };
                    $("#form-builder").append('<div class="mb-3"><button type="submit" class="btn btn-secondary">' + label + '</button></div>');
                    break;

                default:
                    alert('Unknown field type: ' + type);
                    return;
            }

            // Save the field to the data attribute
            $("#form-builder").data('fields', ($("#form-builder").data('fields') || []).concat([field]));
        }


        $("#save-form").click(function() {
            var fields = $("#form-builder").data('fields') || [];
            var formName = prompt("Enter the form name:");

            var formMethod = prompt("Enter the form method: GET, POST, PUT, DELETE").toUpperCase().trim();
            var actionUrl = prompt("Enter the form action URL:").trim();

            var allowedMethods = ['GET', 'POST', 'PUT', 'DELETE'];


            if (allowedMethods.includes(formMethod) && actionUrl !== "" && formName && fields.length > 0) {
                $.ajax({
                    url: '{{ route("save.form") }}',
                    method: 'POST',
                    data: {
                        method: formMethod,
                        action: actionUrl,
                        name: formName,
                        structure: JSON.stringify(fields),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        let url = "{{ url('form') }}/" + response.form_id;
                        window.location.href = url;
                    }
                });
            } else {
                alert('Please add some fields and provide a name for the form.');
            }
        });
    });
</script>
 @endsection

