<style>
    #success-message {
        /* display: none; */
        /* position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        justify-content: center;
        align-items: center; */
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
