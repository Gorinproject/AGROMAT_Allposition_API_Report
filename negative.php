<style type="text/css">

.pos { color:green; }
.neg { color:red; }

</style>

<table>
  <tr><td>+11.11</td><td>-24.88</td><td>00.00</td></tr>
  <tr><td>-11.11</td><td>4.88</td><td>+16.00</td></tr>
</table>

<script type="text/javascript">
$('td').each(function() {
  var val = $(this).text(), n = +val;
  if (!isNaN(n) && /^\s*[+-]/.test(val)) {
    $(this).addClass(val >= 0 ? 'pos' : 'neg')
  }
})
</script>