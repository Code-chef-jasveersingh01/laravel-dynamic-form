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
    <div class="container">
        <form>
            @foreach($formStructure as $field)
                @if($field['type'] == 'text')
                    <div class="mb-3">
                        <label>{{ $field['label'] }}</label>
                        <input type="text" class="form-control">
                    </div>
                @elseif($field['type'] == 'textarea')
                    <div class="mb-3">
                        <label>{{ $field['label'] }}</label>
                        <textarea class="form-control"></textarea>
                    </div>
                @elseif($field['type'] == 'select')
                    <div class="mb-3">
                        <label>{{ $field['label'] }}</label>
                        <select class="form-control">
                            @foreach($field['options'] as $option)
                                <option>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endforeach
        </form>
    </div>

</body>
</html>
