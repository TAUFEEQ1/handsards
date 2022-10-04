<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js" integrity="sha512-2AL/VEauKkZqQU9BHgnv48OhXcJPx9vdzxN1JrKDVc4FPU/MEE/BZ6d9l0mP7VmvLsjtYwqiYQpDskK9dG8KBA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout-jqueryui/2.2.4/knockout-jqueryui.min.js" integrity="sha512-DdwPl4MJIrgqUMbFFSer6slfPKahBVfYjKpQrWwH4sLyQfNA/3RnIvpWZs8+KRXC5QYXt+DtXDtSpZd6rZiBMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.0.2/wordcloud2.min.js" integrity="sha512-f1TzI0EVjfhwKkLEFZnu8AgzzzuUBE9X4YY61EoQJhjH8m+25VKdWmEfTJjmtnm0TEP8q9h+J061kCHvx3NJDA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.6/underscore-min.js" integrity="sha512-2V49R8ndaagCOnwmj8QnbT1Gz/rie17UouD9Re5WxbzRVUGoftCu5IuqqtAM9+UC3fwfHCSJR1hkzNQh/2wdtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name="google-site-verification" content="ObBOzSNfFaSh2kWcB3a74JGWiW476mPhL-OVQrszqB4" />
    <title>UG HANSARDS</title>
</head>

<body>
    <header class="hansard-nav">
        <nav class="navbar navbar-expand-lg navbar-dark mx-auto" style="width:84%;">
            <a class="navbar-brand" href="/">
                <h1 class="hd-title">UG Hansards Review</h1>
            </a>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="mt-3 calendar" id="calendar-wid">
                    <!--Calendar-->
                    <h5 style="text-indent:0.5em;">Select a date</h5>
                    <div data-bind="datepicker: { value: cdate, onChangeMonthYear:onChangeMonthYear}"></div>
                </div>
                <div class="mt-3 col-sm-12 col-md-8" id="hansard-wid">
                    <div class="card">
                        <div class="card-header">
                            <h5>Floor Speakers on <?php echo $publish_date; ?></h5>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h5>Keywords</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="my_canvas"  height="230" width="823"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
<style>
    .hansard-nav {
        background-color: #06283D;
    }

    .hd-title {
        font-size: 1.65em;
        line-height: 1.1;
        font-weight: 500;
    }

    .ui-datepicker {
        width: 20em;
        margin-left: auto;
        margin-right: auto;
    }


    @media only screen and (min-width:769px) {
        .calendar{
            width: 22em;
        }
        #myChart{
            height: 300px;
        }
    }
    @media only screen and (max-width:600px){
        .calendar{
            width:14em;
        }

    }
</style>
<script src="<?php echo base_url(); ?>/js/lightup.js"></script>
<script src="<?php echo base_url(); ?>/js/formatdate.js"></script>
<script type="text/javascript">
    function CalendarView() {
        this.cdate = ko.observable();
        this.cdate(new Date("<?php echo $publish_date; ?>"));
        this.cdate.subscribe((tdate) => {
            window.location.assign("/hansards/" + formatDate(tdate));
        });
        lightUp("<?php echo $publish_date; ?>");
        let dbh = null;
        this.onChangeMonthYear = (year, month) => {
            if (dbh) {
                dbh.cancel();
            }
            dbh = _.debounce(() => {
                let mth = ('0' + month).slice(-2);
                lightUp(`${year}-${mth}-15`);
            }, 800, false);
            dbh();
        }
    }


    ko.applyBindings(new CalendarView(), document.getElementById('calendar-wid'));
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($mps); ?>,
            datasets: [{
                label: '# of MENTIONS',
                data: <?php echo json_encode($mentions) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false
        }
    });
    WordCloud(document.getElementById('my_canvas'), {
        list: <?php echo json_encode($topics); ?>,
        minSize: 5,
        shrinkToFit: true,
        shape: 'square',
        weightFactor: 2
    });
</script>

</html>