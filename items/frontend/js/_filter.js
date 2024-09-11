$(document).ready(function () {

    $('.js-filterNow').on('click', function () {

        // css part toggle active
        $(this).toggleClass('active')

        // js part
        
        var topics = [];
        $('.topicHolder .filterElem.active').each(function () {
            topics.push($(this).attr('topid'))
        })

        var targetGroups = [];
        $('.tgHolder .filterElem.active').each(function () {
            targetGroups.push($(this).attr('tgid'))
        })

        console.log($('.filterElem').length)
        $('.filteredUnit').each(function () {

            $(this).hide();

            const ftopic = $(this).attr("topic").trim().split(" ")
            const ftg = $(this).attr("tg").trim().split(" ")
      
            const foundTopic = ftopic.some(r => topics.includes(r)) || !topics.length
            const foundTg = ftg.some(r => targetGroups.includes(r)) || !targetGroups.length

            if (foundTopic && foundTg) {
                $(this).show();
            }
        
        })


        $('.monthHolder').show();
        $('.monthHolder').each(function() {

            if ($(this).find('.filteredUnit:visible').length) {
                $(this).show()
            } else {
                $(this).hide()
            }
        })

    })

})
