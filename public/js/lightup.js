function lightUp(publish_date) {
    let cdate = new Date(publish_date),
        y = cdate.getFullYear(),
        m = cdate.getMonth();
    let firstDay = new Date(y, m, 1);
    let lastDay = new Date(y, m + 1, 0);
    $.ajax({
        url: '/hansards/dates',
        type: 'get',
        data: {
            start_date: formatDate(firstDay),
            end_date: formatDate(lastDay)
        }
    }).done((days)=>{
        days.forEach(day=>{
            $(`.ui-state-default[data-date='${day}']`).addClass("border border-info border-2");
        });

    });
}