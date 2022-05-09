$(document).ready(function ($) {
  jQuery(".btn-filters").on("click", showFilters);

  jQuery(".orderlist .order-label").on("click", showOrders);
  jQuery(".orderlist .orders .order").on("click", filterByOrder);

  jQuery(".btn-prev").on("click", prevPage);
  jQuery(".btn-next").on("click", nextPage);

  $("#search").on("input", search);
});

function search() {
  const searchTerms = $("#search").val();
  if (searchTerms.length > 3 || searchTerms.length == 0) {
    filters.s = searchTerms;
    loadPremiums();
  }
}

function loadPremiums() {
  jQuery("#results-list").addClass("loading");

  // document.querySelector("#search").scrollIntoView({ behavior: "smooth" });

  const data = {
    action: "load_premiums",
    params: filters,
  };

  jQuery.post(datas.ajaxurl, data, function (response) {
    const query = JSON.parse(response);
    jQuery("#results-count").html(query["found_posts"]);
    removePagination();
    if (query["max_num_pages"] > 1) updatePagination(query["max_num_pages"]);

    const dataTpl = {
      action: "show_premiums_template",
      params: {
        premiums: query["posts"],
        reinsurance: filters.reinsurance,
        empty_list_message: filters.empty_list_message,
      },
    };
    jQuery.post(datas.ajaxurl, dataTpl, function (template) {
      jQuery("#results-list .premium-list").html(template);
      jQuery("#results-list").removeClass("loading");
    });
  });
}

function updatePagination(nb_pages) {
  filters.max_num_pages = nb_pages;
  jQuery("#pagination .current").html(filters.paged + "/" + nb_pages);
  jQuery("#pagination").show();
}

function removePagination() {
  jQuery("#pagination").hide();
}

function nextPage() {
  if (filters.paged < filters.max_num_pages) {
    filters.paged++;
    loadPremiums();
  } else {
    filters.paged = filters.max_num_pages;
  }
}

function prevPage() {
  if (filters.paged > 1) {
    filters.paged--;
    loadPremiums();
  } else filters.paged = 1;
}

function filterByOrder(e) {
  filters.order = jQuery(e.currentTarget).data("order");
  filters.order_by = jQuery(e.currentTarget).data("orderby");
  hideOrders();
  loadPremiums();
}

function showOrders() {
  hideFilters();
  if (jQuery(".orderlist .orders").hasClass("visible")) {
    hideOrders();
    return;
  }
  jQuery(".orderlist .orders").addClass("visible");
}

function hideOrders() {
  jQuery(".orderlist .orders").removeClass("visible");
}

function showFilters() {
  hideOrders();
  if (jQuery(".filterslist").hasClass("visible")) {
    hideFilters();
    return;
  }

  jQuery("body").addClass("overflow-hidden");
  jQuery(".filterslist").addClass("visible");
  jQuery(".filterslist .close").on("click", hideFilters);
  $('.filterslist input[type="checkbox"]').on("click", addFilter);
}

function hideFilters() {
  jQuery("body").removeClass("overflow-hidden");
  jQuery(".filterslist .close").off("click", hideFilters);
  $('.filterslist input[type="checkbox"]').off("click", addFilter);
  jQuery(".filterslist").removeClass("visible");
}

function addFilter(e) {
  const parent = jQuery(e.currentTarget).closest(".item");
  const type = parent.attr("data-type");
  const value = parent.attr("data-value");

  switch (type) {
    case "favorite":
      filters.favorites = $(this).prop("checked");
      break;
    case "category":
      if (!$(this).prop("checked")) {
        filters.categories = filters.categories.filter((elem) => {
          return elem != value;
        });
      } else {
        filters.categories.push(value);
      }
      break;
    case "tag":
      if (!$(this).prop("checked")) {
        filters.tags = filters.tags.filter((elem) => {
          return elem != value;
        });
      } else {
        filters.tags.push(value);
      }
      break;
    case "premiumtype":
      if (!$(this).prop("checked") && filters.premiumtype.includes(value)) {
        filters.premiumtype = filters.premiumtype.filter((elem) => {
          return elem != value;
        });
      } else {
        filters.premiumtype.push(value);
      }
      break;
  }

  loadPremiums();
}
