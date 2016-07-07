<div id="container"></div>

<?= $this->Form->create(null); ?>
<?= $this->Form->input('createdFrom', ['readonly' => 'readonly', 'id' => 'createdFrom']); ?>
<?= $this->Form->input('createdTo', ['readonly' => 'readonly', 'id' => 'createdTo']); ?>
<?= $this->Form->input('widthFrom'); ?>
<?= $this->Form->input('widthTo'); ?>
<?= $this->Form->button('Search'); ?>
<?= $this->Form->end(); ?>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
$(function () {

    $('#container').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: '近隣マンション相場（賃貸）'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                second: '%H:%M:%S',
                minute: '%H:%M',
                hour: '%m/%e %H:%M',
                day: '%Y/%m/%e',
                week: '%Y/%m/%e',
                month: '%Y/%m',
                year: '(%Y)'
            },
            title: {
                text: '日付'
            }
        },
        yAxis: {
            title: {
                text: '価格(万円)'
            },
            min: <?= $min ?>
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%Y/%m/%d}: {point.y:.2f} 万円'
        },

        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        series: JSON.parse('<?= $graphJson ?>')

    });

    $( "#createdFrom" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#createdTo" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
});
</script>