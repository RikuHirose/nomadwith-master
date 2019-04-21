<script type="text/javascript">
  window.User = <?php echo json_encode($user); ?>
</script>
<script>
  if (window.location.hash == "#_=_") window.location.hash = "";
</script>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>