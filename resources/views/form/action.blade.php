<div class="d-flex align-items-center" >
    <!-- View Button -->
    <a href="{{ route('form.show', ['id' => $id]) }}" class="btn btn-info btn-sm">
        <ion-icon name="eye"></ion-icon>
    </a>

    <!-- Edit Button -->
    <a href="{{ route('form.edit', ['id' => $id]) }}" class="btn btn-warning btn-sm mx-1">
        <ion-icon name="create"></ion-icon>
    </a>

    <!-- Delete Button -->
    <form action="{{ route('form.destroy', ['id' => $id]) }}" method="POST" >
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm " onclick="return confirm('Are you sure you want to delete this form?');">
            <ion-icon name="trash"></ion-icon>
        </button>
    </form>
</div>
