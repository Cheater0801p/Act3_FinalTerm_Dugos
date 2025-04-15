@extends('layouts.contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
    <h4>Student List</h4>

    @foreach($students as $student)
        <div>
            <a href="{{ route('students.edit', ['id' => $student->id]) }}">
                <i class="bx bx-edit"></i> Edit
            </a>
            <a href="#" class="delete" data-id="{{ encrypt($student->id) }}">
                <i class="bx bx-trash"></i> Delete
            </a>
            {{ $student->name }} {{ $student->lastname }}
        </div>
    @endforeach
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   
    $(document).on("click", ".delete", function(e){
        e.preventDefault();  
        let encryptedId = $(this).data("id");  
        let row = $(this).closest("div"); 

       
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('students.delete') }}", 
                    method: "POST",
                    data: {
                        id: encryptedId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire("Deleted!", "Student has been deleted.", "success");
                        row.fadeOut(500, function() {
                            $(this).remove();
                        });
                    },
                    error: function() {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    }
                });
            }
        });
    });
</script>
