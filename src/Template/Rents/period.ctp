<!--Div that will hold the pie chart-->
<div id="chart_div"></div>

<? $form = $this->Form;?>
<?= $form->create(null); ?>
<?= $form->input('from', ['readonly' => 'readonly', 'id' => 'createdFrom']); ?>
<?= $form->input('to', ['readonly' => 'readonly', 'id' => 'createdTo']); ?>
<?= $form->button('Search'); ?>
<?= $form->end(); ?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'X');
        data.addColumn('number', '賃貸物件数');

        var rows = [];

        <?php foreach ($query as $rent): ?>
            rows.push(['<?= $rent->created->i18nFormat('yyyy-MM-dd') ?>', <?= $rent->count ?>]);
        <?php endforeach; ?>

        data.addRows(rows);

        var options = {
            hAxis: {
                title: '日付'
            },
            vAxis: {
                title: '物件数'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>
<script>
    $(function() {
        $( "#createdFrom" ).datepicker({
            dateFormat: "yy-mm-dd"
        });
        $( "#createdTo" ).datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>