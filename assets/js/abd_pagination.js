
let curPage = 1;
let totalPages = 2;
let recordPerPage = 4;

let formAction = "index.php?";
let table = "posts";
let query = "SELECT * FROM " + table;
$(document).ready(function () {
    loadData(table, curPage, "#post-list", recordPerPage, formAction, query); 
    var observer = new MutationObserver(function (mutations, me) {
        var postList = document.getElementById('post-list');
        if (postList) {
            setPaginationButton(table, "#post-list", document.getElementById('page-number'));
            me.disconnect();
            return;
        }
    });
    observer.observe(document, {
        childList: true,
        subtree: true
    });
    document.getElementById("search").addEventListener('click', function () {
        keywords = String(document.getElementById("searchbox").value).trim().split(" ");
        searchQuery = "SELECT * FROM posts WHERE";
        var i = keywords.length;
        keywords.forEach(keyword => {
            searchQuery += " (SELECT username FROM users where users.id=posts.user_id) LIKE '%" + keyword + "%' OR posts.postTitle LIKE '%" + keyword + "%'";
            i--;
            if (i > 0) {
                searchQuery += " OR"
            }
        });
        curPage=1;
        loadData(table, curPage, "#post-list", recordPerPage, formAction, searchQuery);
        var observer = new MutationObserver(function (mutations, me) {
            var postList = document.getElementById('post-list');
            if (postList) {
                console.log("settled");
                setPaginationButton(table, "#post-list", document.getElementById('page-number'));
                me.disconnect();
                return;
            }
        });
        observer.observe(document, {
            childList: true,
            subtree: true
        });
    });
    function loadData(table, page, container, recordPerPage, formAction, query) {
        $.ajax({
            url: "app/helpers/pagination.php",
            method: "POST",
            dataType: "json",
            data: {
                table: table,
                page: page,
                recordPerPage: recordPerPage,
                formAction: formAction,
                query: query
            },
            success: function (data) {
                totalPages = data.pagesCount;
                $(container).html(data.posts);
                
                $('[data-id]').click(function(){
                    var buttonId = $(this).attr('data-id');
                    $.ajax({
                        type: "POST",
                        url: "app/includes/like.php?postid="+buttonId,
                        processData: false,
                        contentType: "application/json",
                        data: '',
                        success: function(resp){
                            var res = JSON.parse(resp);
                           $("[data-id='"+buttonId+"']").html((res.liked?'Liked ':'Like ') + res.likes);
                           $("[data-id='"+buttonId+"']").css("color",res.liked?"rgba(216, 114, 67)":"rgba(55, 55, 55)");
                        }
                    });
                });
            }
        })
    }

    function setPaginationButton(table, postContainer, pageNumWrapper) {
        if (totalPages <= 1)
            return;
        for (i = 1; i <= totalPages; i++) {
            let button = document.createElement('button');
            button.innerText = i;
            if (curPage === i)
                button.classList.add('active');
            let page = i;
            button.addEventListener('click', function () {
                curpage = page;
                let curBtn = document.querySelector('.' + pageNumWrapper + ' button.active');
                curBtn.classList.remove('active');
                button.classList.add('active');
                loadData(table, page, postContainer, recordPerPage, formAction, query);
            });
            pageNumWrapper.appendChild(button);
        }
    }
})
