<div class="chart" id="{{ $key }}" style="height: 150px;"></div>
<script>
    $(document).ready(function () {
        drawLineChart(<?=json_encode($data); ?>, <?=json_encode($key); ?>, <?=json_encode($name); ?>, 'bar');
    });
</script>
