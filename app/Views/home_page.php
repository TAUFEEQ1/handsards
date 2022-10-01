<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js" integrity="sha512-2AL/VEauKkZqQU9BHgnv48OhXcJPx9vdzxN1JrKDVc4FPU/MEE/BZ6d9l0mP7VmvLsjtYwqiYQpDskK9dG8KBA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>UG HANSARDS</title>
</head>

<body>
    <header class="hansard-nav">
        <nav class="navbar navbar-expand-lg navbar-dark mx-auto" style="width:84%;">
            <a class="navbar-brand" href="#">
                <h1 class="hd-title">Hansards</h1>
            </a>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <!--Calendar-->
                    <div class="card mt-2 pb-2">
                        <div class="card-header">
                            <h4>Select a date</h4>
                        </div>
                        <div class="card-body">
                            <form class="mt-2 mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <select class="form-control" data-bind="value:current_month">
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <input class="form-control" type="number" value="2022" disabled />
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="calendar-container mx-auto">
                                <thead class="calendar-header">
                                    <tr class="calendar-weekdays">
                                        <th scope="col" abbr="Monday">Mon</th>
                                        <th scope="col" abbr="Tuesday">Tue</th>
                                        <th scope="col" abbr="Wednesday">Wed</th>
                                        <th scope="col" abbr="Thursday">Thu</th>
                                        <th scope="col" abbr="Friday">Fri</th>
                                        <th scope="col" abbr="Saturday">Sat</th>
                                        <th scope="col" abbr="Sunday">Sun</th>
                                    </tr>
                                </thead>
                                <tbody class="calendar-month" data-bind="foreach: { data:days, as: 'week' }">
                                    <tr data-bind="foreach: {data:week, as:'day'}">
                                        <td data-bind="text:day,css:{'calendar-day':day.length!=0}" class="text-center">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    
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

    .calendar-container {
        width: 24em;
    }

    .calendar-weekdays>th {
        text-align: center;
    }

    .calendar-day {
        line-height: 2.8em;
        width: 2em;
    }

    .calendar-day:hover {
        background-color: #06283D;
        color: white;
        cursor: pointer;
        border-radius: .25em;
    }
</style>
<script type="text/javascript">
    function CalendarViewModel() {
        this.today = new Date();
        this.current_month = ko.observable(this.today.getMonth());
        this.current_year = this.today.getFullYear();
        this.days = ko.observableArray(this.reset());
        this.setMonth();
        this.current_month.subscribe(() => {
            this.setMonth();
        });

    }
    CalendarViewModel.prototype = {
        reset() {
            return new Array(6).fill(new Array(7).fill(""));
        },
        startDate() {
            const day = new Date(this.current_year, this.current_month()-1, 1).getDay();
            return day?day-1:6;
        },
        setMonth() {
            let arr = this.reset().flat();
            const getDays = (year, month) => {
                return new Date(year, month, 0).getDate();
            };
            const mths = getDays(this.current_year,this.current_month());
            arr.splice(this.startDate(), mths, ...Array.from(new Array(mths), (x, i) => i + 1));
            let tmp = this.reset();
            this.days.removeAll();
            for (let index = 0; index < tmp.length; index++) {
                this.days.push(arr.slice(index * 7, (index + 1) * 7));
            }
        }
    }

    let calendar = new CalendarViewModel();
    ko.applyBindings(calendar);
</script>

</html>