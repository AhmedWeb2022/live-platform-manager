<style>
  #success-message {
    background-color: rgba(187, 230, 183, 0.5);
    color: white;
    font-size: 20px;
    font-weight: bold;
  }
</style>


@if (session('success'))
  <div id="success-message" class="alert alert-success">
    {{ session('success') }}
  </div>
@endif
@if (session('error'))
  <div id="success-message" class="alert alert-danger">
    {{ session('error') }}
  </div>
@endif

<script>
  $(document).ready(function() {
    setTimeout(function() {
      $('#success-message').hide();
    }, 3000);
  });
</script>
