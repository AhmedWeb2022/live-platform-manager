{{-- <div> --}}
    <button class="add-newproject" onclick="destroy({{ $id }})">
        <i class="fa-solid fa-trash"></i>
      </button>

      <a href="{{ route('admin.live_account.edit', $id) }}">
        <button class="add-newproject">
          <i class="fa-solid fa-pen-to-square"></i>
        </button>
      </a>
      {{-- </div> --}}
      <script>
        function destroy(id) {
          var table = $('.dataTable').DataTable();
          var url = `{{ route('admin.live_account.destroy', ':id') }}`.replace(':id', id);

          // Show confirmation dialog using Swal
          Swal.fire({
            title: "Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancel",
            confirmButtonText: "Sure",
          }).then((result) => {
            if (result.isConfirmed) {
              // Send AJAX request to delete the item
              $.ajax({
                type: 'POST',
                url: url,
                data: {
                  '_method': 'POST',
                  '_token': "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                  if (response.status === true) {
                    Swal.fire(
                      "Deleted",
                      "Deleted Successfully",
                      'success'
                    );
                    // Reload the DataTable
                    table.ajax.reload();
                  } else {
                    Swal.fire(
                      "{{ __('messages.error') }}",
                      response.message,
                      'error'
                    );
                  }
                },
                error: function(xhr) {
                  Swal.fire(
                    "{{ __('messages.error') }}",
                    xhr.responseJSON?.message,
                    'error'
                  );
                }
              });
            }
          });
        }
      </script>
