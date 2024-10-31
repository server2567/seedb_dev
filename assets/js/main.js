/**
* Template Name: BoomAdmin
* Updated: 20/8/2566 with Bootstrap v1
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Author: Boom
* License: https://bootstrapmade.com/license/
*/
(function () {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar: toggle
   */
  // Initiate toggle-sidebar
  document.addEventListener("DOMContentLoaded", function (event) {
    if (window.matchMedia('screen and (min-width: 1200px)').matches) {
      if (typeof (Storage) !== "undefined" && localStorage.getItem("is_toggle_sidebar") == "true")
        select('.toggle-sidebar-btn').click();
    }
  })
  // When click toggle-sidebar-btn
  if (select('.toggle-sidebar-btn')) {
    on('click', '.toggle-sidebar-btn', function (e) {
      const body = select('body');
      body.classList.toggle('toggle-sidebar');

      const menu_heads = select('.sidebar .menu-head', true);
      menu_heads.forEach(menu_head => {
        menu_head.classList.toggle('d-none');
        // menu_head.classList.toggle('dropdown-menu');
      });

      // for desktop screen: setting sidebar sub menu
      if (window.matchMedia('screen and (min-width: 1200px)').matches) {
        const menus = select('.sidebar li.nav-item', true);
        menus.forEach(menu => {
          menu.classList.toggle('btn-group');
        });

        // change collapsed to dropdown sub menu
        const contents = select('ul.nav-content', true);
        contents.forEach(content => {
          content.classList.toggle('dropdown-menu');
          if (body.classList.contains('toggle-sidebar')) {
            content.classList.remove('show')
          }
        });

        if (body.classList.contains('toggle-sidebar')) {
          // set localStorage
          localStorage.setItem("is_toggle_sidebar", true);

          // set not collapsed toggle
          const links = select('.sidebar a.nav-link', true);
          links.forEach(navlink => {
            if (navlink.hasAttribute('data-bs-toggle'))
              navlink.setAttribute('data-bs-toggle', '');

            // set default: not show collapsed sub menu
            navlink.classList.add('collapsed')
          });

          // setting overflow-y: when hover menu that have sub menu -> overflow-y hidden (for protect sub menu dissapear)
          const navItems = select('.toggle-sidebar .sidebar .nav-item', true);
          const sidebar = select('.toggle-sidebar .sidebar');
          navItems.forEach(navItem => {
            if (navItem.children.length > 0) {
              Array.from(navItem.children).forEach(ul => {
                if (ul.tagName.toLowerCase() === 'ul') {
                  navItem.addEventListener('mouseover', () => {
                    sidebar.style.overflowY = 'hidden';
                    ul.style.top = parseInt(navItem.getBoundingClientRect().top) + 'px';
                  });

                  navItem.addEventListener('mouseout', () => {
                    sidebar.style.overflowY = 'auto';
                  });
                }
              });
            }
          });
        } else {
          // set localStorage
          localStorage.setItem("is_toggle_sidebar", false);

          const links = select('.sidebar a.nav-link', true);
          links.forEach(navlink => {
            if (navlink.hasAttribute('data-bs-toggle'))
              navlink.setAttribute('data-bs-toggle', 'collapse');
          });
        }
      }
      setActiveMenu();
    })
  }

  /**
   * Search bar toggle
   */
  // if (select('.search-bar-toggle')) {
  //   on('click', '.search-bar-toggle', function(e) {
  //     select('.search-bar').classList.toggle('search-bar-show')
  //   })
  // }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Initiate quill editors
   */
  if (select('.quill-editor-default')) {
    let el = select('.quill-editor-default', true)
    el.forEach(e => {
      new Quill(e, {
        theme: 'snow'
      });
      $('.ql-container').addClass('custom-height').css('height', '200px');
    });
  }

  // if (select('.quill-editor-bubble')) {
  //   new Quill('.quill-editor-bubble', {
  //     theme: 'bubble'
  //   });
  // }

  // if (select('.quill-editor-full')) {
  //   new Quill(".quill-editor-full", {
  //     modules: {
  //       toolbar: [
  //         [{
  //           font: []
  //         }, {
  //           size: []
  //         }],
  //         ["bold", "italic", "underline", "strike"],
  //         [{
  //           color: []
  //         },
  //         {
  //           background: []
  //         }
  //         ],
  //         [{
  //           script: "super"
  //         },
  //         {
  //           script: "sub"
  //         }
  //         ],
  //         [{
  //           list: "ordered"
  //         },
  //         {
  //           list: "bullet"
  //         },
  //         {
  //           indent: "-1"
  //         },
  //         {
  //           indent: "+1"
  //         }
  //         ],
  //         ["direction", {
  //           align: []
  //         }],
  //         ["link", "image", "video"],
  //         ["clean"]
  //       ]
  //     },
  //     theme: "snow"
  //   });
  // }

  /**
   * Initiate TinyMCE Editor
   */
  var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;
  useDarkMode = false; // [AP] fix for use light theme
  tinymce.init({
    selector: 'textarea.tinymce-editor',
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
    editimage_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    toolbar_sticky: true,
    toolbar_sticky_offset: isSmallScreen ? 102 : 108,
    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_prefix: '{path}{query}-{id}-',
    autosave_restore_when_empty: false,
    autosave_retention: '2m',
    image_advtab: true,
    link_list: [{
      title: 'My page 1',
      value: 'https://www.tiny.cloud'
    },
    {
      title: 'My page 2',
      value: 'http://www.moxiecode.com'
    }
    ],
    image_list: [{
      title: 'My page 1',
      value: 'https://www.tiny.cloud'
    },
    {
      title: 'My page 2',
      value: 'http://www.moxiecode.com'
    }
    ],
    image_class_list: [{
      title: 'None',
      value: ''
    },
    {
      title: 'Some class',
      value: 'class-name'
    }
    ],
    importcss_append: true,
    file_picker_callback: (callback, value, meta) => {
      /* Provide file and text for the link dialog */
      if (meta.filetype === 'file') {
        callback('https://www.google.com/logos/google.jpg', {
          text: 'My text'
        });
      }

      /* Provide image and alt text for the image dialog */
      if (meta.filetype === 'image') {
        callback('https://www.google.com/logos/google.jpg', {
          alt: 'My alt text'
        });
      }

      /* Provide alternative source and posted for the media dialog */
      if (meta.filetype === 'media') {
        callback('movie.mp4', {
          source2: 'alt.ogg',
          poster: 'https://www.google.com/logos/google.jpg'
        });
      }
    },
    templates: [{
      title: 'New Table',
      description: 'creates a new table',
      content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
    },
    {
      title: 'Starting my story',
      description: 'A cure for writers block',
      content: 'Once upon a time...'
    },
    {
      title: 'New list with dates',
      description: 'New List with dates',
      content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
    }
    ],
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 600,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_class: 'mceNonEditable',
    toolbar_mode: 'sliding',
    contextmenu: 'link image table',
    skin: useDarkMode ? 'oxide-dark' : 'oxide',
    content_css: useDarkMode ? 'dark' : 'default',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
  });

  /**
   * Initiate Add required label
   */
  document.addEventListener("DOMContentLoaded", function (event) {
    let span = document.createElement("span");
    span.classList.add('text-danger')
    span.textContent = ' *';

    var labels = select('label.required', true);
    labels.forEach(function (label) {
      label.insertAdjacentHTML('afterend', span.outerHTML);
    });
  })

  /**
   * Initiate Select2 Single select Multiple select
   */
  document.addEventListener("DOMContentLoaded", function (event) {
    $('.select2').select2({
      theme: "bootstrap-5",
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: true,
    });
  })

  /**
   * Initiate Select2 Multiple select
   */
  document.addEventListener("DOMContentLoaded", function (event) {
    $('.select2-multiple').select2({
      theme: "bootstrap-5",
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: true,
      closeOnSelect: false,
    });
  })

  /**
   * Form submit (save) and validation
   */
  document.addEventListener("DOMContentLoaded", function (event) {

    // Initial div invalid default
    var inputs = [...document.querySelectorAll('input, span.select2')];
    inputs.forEach(in_er => {
      let div = document.createElement("div");
      div.classList.add('invalid-feedback')
      div.append(text_invalid_default);
      in_er.insertAdjacentElement('afterend', div);
      // in_er.classList.add('is-invalid')
    });

    // Initiate Submit form and Bootstrap validation check
    var needsValidation = select('.needs-validation', true);

    Array.prototype.slice.call(needsValidation)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          event.preventDefault();
          // // event.stopPropagation();
            
          // new solution for can submit file
          if (form.checkValidity()) {
            clear_input_invalid();
            $.ajax({
                url: form.getAttribute('action'),
                type:"post",
                data: new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                dataType: 'json',
                success: function(data){
                    if (data.data.status_response == status_response_success) {
                        dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, data.data.returnUrl, false);
                    } else if (data.data.status_response == status_response_error) {
                        if (!is_null(data.data.error_inputs)) {
                          setInvalidInput(data.data.error_inputs);
                        }

                        if (!is_null(data.data.message_dialog))
                            dialog_error({ 'header': text_toast_save_error_header, 'body': data.data.message_dialog });
                        else
                            dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
                    }
                },
                error: function(xhr, status, error) {
                    console.log("error")
                    console.log(xhr)
                    console.log(status)
                    console.log(error)
                    $('#response').html('An error occurred: ' + error);
                }
            });
          }
          
          // old solution
          // if (form.checkValidity()) {

          //   clear_input_invalid();

          //   // Get data from form
          //   var formData = $(form).serialize();
          //   console.log(formData);
          //   $.post(form.getAttribute('action'), formData, function (data) {
          //     console.log("data.data.status_response ", data.data.status_response)
          //     console.log("data ", data)
          //     if (data.data.status_response == status_response_success) {
          //       dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, data.data.returnUrl, false);
          //     } else if (data.data.status_response == status_response_error) {
          //       if (!is_null(data.data.error_inputs)) {
          //         const errors = Object.entries(data.data.error_inputs);
          //         if (errors.length > 0) {
          //           for (const [key, value] of Object.entries(errors)) {
          //             var val = value[1];
          //             var input_errors = [...document.querySelectorAll('input[name="' + val['name'] + '"]')];
          //             input_errors.forEach(in_er => {
          //               // Find the next element with a specific class
          //               var div_invalid = in_er.nextElementSibling;
          //               if (div_invalid && div_invalid.classList.contains('invalid-feedback')) {
          //                 div_invalid.innerHTML = val['error'];
          //               }
          //               in_er.classList.add('is-invalid')
          //             });
          //           }
          //         }
          //       }

          //       if (!is_null(data.data.message_dialog))
          //         dialog_error({ 'header': text_toast_save_error_header, 'body': data.data.message_dialog });
          //       else
          //         dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
          //     }
          //   }, 'json')
          //     .fail(function (jqXHR, textStatus, errorThrown) {
          //       console.error('Error Status:', textStatus);
          //       console.error('Error Thrown:', errorThrown);
          //       console.error('Response Text:', jqXHR.responseText);
          //       // alert( "error" );
          //     }, 'json')
          // }
          // // else {

          // // }

          form.classList.add('was-validated')
        }, false)
      })
  })


  /**
   * Initiate Datatables
   */
  // document.addEventListener("DOMContentLoaded", function(event) {
  //   var datatables = select('.datatable', true);
  //   datatables.forEach(datatable => {
  //     // var table = new DataTable.DataTable('.datatable');
  //     var table = new simpleDatatables.DataTable(datatable);
  //     // Update language options
  //     var updatedOptions = {
  //         labels: {
  //             info: "แสดงรายการที่ {start} - {end} จากทั้งหมด {rows} รายการ",
  //             noResults: "ไม่พบรายการ",
  //             noRows: "ไม่มีรายการในระบบ",
  //             perPage: " ",
  //             placeholder: "ค้นหา...",
  //             searchTitle: "Search within table"
  //         },
  //         // Add other options here
  //     };

  //     // Destroy the existing instance and reinitialize with updated options
  //     table.destroy();
  //     new simpleDatatables.DataTable(datatable, updatedOptions);
  //   })
  // });

  pdfMake.fonts = {
    THSarabun: {
      normal: 'THSarabun.ttf',
      bold: 'THSarabun-Bold.ttf',
      italics: 'THSarabun-Italic.ttf',
      bolditalics: 'THSarabun-BoldItalic.ttf'
    }
  }

  new DataTable('.datatable', {
    // responsive: true,
    language: {
      decimal: "",
      emptyTable: "ไม่มีรายการในระบบ",
      info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
      infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
      infoFiltered: "(filtered from _MAX_ total entries)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "_MENU_",
      loadingRecords: "Loading...",
      processing: "",
      search: "",
      searchPlaceholder: 'ค้นหา...',
      zeroRecords: "ไม่พบรายการ",
      paginate: {
        first: "«",
        last: "»",
        next: "›",
        previous: "‹"
      },
      aria: {
        orderable: "Order by this column",
        orderableReverse: "Reverse order this column"
      },
    },
    dom: 'lBfrtip',
    buttons: [{
      extend: 'print',
      // exportOptions: {
      //   columns: [0, 1, 2]
      // },
      text: '<i class="bi-file-earmark-fill"></i> Print',
      titleAttr: 'Print',
      title: 'รายการข้อมูล'
    },
    {
      extend: 'excel',
      // exportOptions: {
      //   columns: [0, 1, 2, 3, 4, 5]
      // },
      text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
      titleAttr: 'Excel',
      title: 'รายการข้อมูล'
    },
    {
      extend: 'pdf',
      // exportOptions: {
      //   columns: [0, 1, 2]
      // },
      text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
      titleAttr: 'PDF',
      title: 'รายการข้อมูล',
      "customize": function (doc) {
        doc.defaultStyle = { font: 'THSarabun' };
      }
    },
    ],
    initComplete: function() {
      var api = this.api();
      api.on('draw', function() {
        if (api.rows({ filter: 'applied' }).data().length === 0) {
          $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
        }
      });
    }
  });

  /**
   * Autoresize echart charts
   */
  const mainContainer = select('#main');
  if (mainContainer) {
    setTimeout(() => {
      new ResizeObserver(function () {
        select('.echart', true).forEach(getEchart => {
          echarts.getInstanceByDom(getEchart).resize();
        })
      }).observe(mainContainer);
    }, 200);
  }

  /**
   * Initiate Default Tooltips
   */
  document.addEventListener("DOMContentLoaded", function (event) {
    setTooltipDefault();
  });

  /**
   * Event button: delete (alert)
   */
  // document.addEventListener("DOMContentLoaded", function(event) {
  //   const deletes = select('.option .swal-delete', true);
  //   Array.prototype.slice.call(deletes).forEach(function(d) {
  //     d.addEventListener('click', function(event) {
  //       Swal.fire({
  //         title: text_swal_delete_title,
  //         text: text_swal_delete_text,
  //         icon: "warning",
  //         showCancelButton: true,
  //         confirmButtonColor: "#198754",
  //         cancelButtonColor: "#dc3545",
  //         confirmButtonText: text_swal_delete_confirm,
  //         cancelButtonText: text_swal_delete_cancel
  //       }).then((result) => {
  //         if (result.isConfirmed) {
  //           const url = d.getAttribute('data-url');
  //           $.ajax({
  //             url: url,
  //             type: 'POST',
  //             dataType: 'json',
  //             // data: {
  //             //   zipcode: 97201
  //             // },
  //             success: function(data) {
  //               if (data.data.status_response == status_response_success) {
  //                 dialog_success({'header': text_toast_delete_success_header, 'body': text_toast_delete_success_body}, null, true);
  //               } else if (data.data.status_response == status_response_error) {
  //                 dialog_error({'header':text_toast_delete_error_header, 'body': text_toast_delete_error_body});
  //               } 
  //             },
  //             error: function(xhr, status, error) {
  //               console.error(xhr);
  //               dialog_error({'header':text_toast_delete_error_header, 'body': text_toast_delete_error_body});
  //             }
  //           });
  //         }
  //       });
  //     });
  //   });
  // });
  $(document).on('click', '.option .swal-delete', function () {
    const url = $(this).data('url');
    Swal.fire({
      title: text_swal_delete_title,
      text: text_swal_delete_text,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#198754",
      cancelButtonColor: "#dc3545",
      confirmButtonText: text_swal_delete_confirm,
      cancelButtonText: text_swal_delete_cancel
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: url,
          type: 'POST',
          dataType: 'json',
          // data: {
          //   zipcode: 97201
          // },
          success: function (data) {
            if (data.data.status_response == status_response_success) {
              dialog_success({ 'header': text_toast_delete_success_header, 'body': text_toast_delete_success_body }, null, true);
            } else if (data.data.status_response == status_response_error) {
              dialog_error({ 'header': text_toast_delete_error_header, 'body': text_toast_delete_error_body });
            }
          },
          error: function (xhr, status, error) {
            console.error(xhr);
            dialog_error({ 'header': text_toast_delete_error_header, 'body': text_toast_delete_error_body });
          }
        });
      }
    });

  });
  // document.addEventListener("DOMContentLoaded", function(event) {
  //   const deletes = select('.option button.btn-success', true);
  //   Array.prototype.slice.call(deletes).forEach(function(d) {
  //     d.addEventListener('click', function(event) {
  //       Swal.fire({
  //         title: "บันทึกข้อมูล",
  //         text: "คุณต้องการบันทึกข้อมุลหรือไม่?",
  //         icon: "warning",
  //         showCancelButton: true,
  //         confirmButtonColor: "#198754",
  //         cancelButtonColor: "#dc3545",
  //         confirmButtonText: "ตกลง",
  //         cancelButtonText: "ยกเลิก"
  //       }).then((result) => {
  //         if (result.isConfirmed) {
  //           const url = d.getAttribute('data-url');
  //           $.ajax({
  //             url: url,
  //             type: 'POST',
  //             dataType: 'json',
  //             // data: {
  //             //   zipcode: 97201
  //             // },
  //             success: function(data) {
  //               if (data.data.status_response == status_response_success) {
  //                 dialog_success({'header': "บันทึกข้อมูลสำเร็จ"}, null, true);
  //               } else if (data.data.status_response == status_response_error) {
  //                 dialog_error({'header': "ไม่สามารถลบข้อมูลได้!"});
  //               } 
  //             },
  //             error: function(xhr, status, error) {
  //               console.error(xhr);
  //               dialog_error({'header': "ไม่สามารถบันทึกข้อมูลได้!"});
  //             }
  //           });
  //         }
  //       });
  //     });
  //   });
  // });

  /**
   * Input type file: get file for set in tag input (Single file)
   */
  document.addEventListener("DOMContentLoaded", async function(event) {
  const files = select('input.input-bs-file', true);
  
    for (const f of files) {
      const url = $(f).data('url');
      if (!is_null(url)) {
        try {
          const response = await fetch(url);
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
  
          // Get headers
          const contentType = response.headers.get('content-type') || 'application/octet-stream';
          const contentDisposition = response.headers.get('content-disposition');
  
          let fileName = 'default-filename.ext'; // Fallback filename
  
          // Extract filename from content-disposition header if available
          if (contentDisposition) {
            const match = contentDisposition.match(/filename="?([^"]+)"?/);
            if (match) {
              fileName = match[1];
            }
          }
  
          // Create a new ReadableStream from the response body
          const reader = response.body.getReader();
  
          // Read and process chunks of data
          const chunks = [];
          while (true) {
            const { done, value } = await reader.read();
            if (done) break;
  
            // Append each value to the chunks
            chunks.push(value);
          }
  
          // Concatenate all chunks into a single Blob
          const blob = new Blob(chunks);
  
          // Create a File object with the Blob and file name
          const file = new File([blob], fileName, { type: contentType });
  
          // Create a new FileList and append the File
          const fileList = new DataTransfer();
          fileList.items.add(file);
  
          // Assign the FileList to the input element
          f.files = fileList.files;
        } catch (error) {
          console.error('Error:', error);
        }
      }
    }
  });
})();

/**
 * is_null(value) : Function to check if a value is null, empty, or undefined
 */
function is_null(value) {
  if (value !== null && value !== '' && value !== undefined) return false
  else return true
}

/**
 * clear_input_invalid() : Function to remove [class="is-invalid"] in [div class ="invalid-feedback"]
 */
function clear_input_invalid() {
  var inputs = [...document.querySelectorAll('input')];
  inputs.forEach(in_er => {
    in_er.classList.remove('is-invalid')
  });
}

/**
 * Default Dialog Notics : Function to show toast by 'statusOK' that send from controller when loaded page
 */
function default_notics(statusOK, message = "") {
  switch (statusOK) {
    case 0:
      // No notice needed
      break;
    case 1:
      // Success notice
      dialog_success({ 'body': message });
      break;
    case 2:
      // Error notice
      dialog_error({ 'body': message });
      break;
  }
}

/**
 * Setting Dialog : Function to display a success toast notification with customizable configuration options.
 */
function dialog_success(config, url, isReload) {
  // If config is null, set it to an empty object
  config = is_null(config) ? {} : config;
  // Define default configuration for success toast
  const default_config = {
    header: is_null(config.header) ? text_toast_default_success_header : config.header,
    headerClass: is_null(config.headerClass) ? "bg-success text-light border-0" : config.headerClass,
    body: is_null(config.body) ? text_toast_default_success_body : config.body,
    closeButton: is_null(config.closeButton) ? true : config.closeButton,
    closeButtonLabel: is_null(config.closeButtonLabel) ? "close" : config.closeButtonLabel,
    closeButtonClass: is_null(config.closeButtonClass) ? "" : config.closeButtonClass,
    toastClass: is_null(config.toastClass) ? "bg-success text-light border-0" : config.toastClass,
    icon: is_null(config.icon) ? "bi bi-check-circle me-1" : config.icon,
    animation: is_null(config.animation) ? true : config.animation,
    delay: is_null(config.delay) ? 2000 : config.delay,
    position: is_null(config.position) ? "top-0 end-0" : config.position,
    direction: is_null(config.direction) ? "append" : config.direction,
    ariaLive: is_null(config.ariaLive) ? "assertive" : config.ariaLive,
  };
  // Display success toast with default configuration
  bootstrap.showToast(default_config);
  // Redirect or reload after toast is hidden, if specified
  redirectAfterToast(url, isReload);
}

// Function to display an error toast notification with customizable configuration options.
function dialog_error(config, url, isReload) {
  // If config is null, set it to an empty object
  config = is_null(config) ? {} : config;
  // Define default configuration for error toast
  const default_config = {
    header: is_null(config.header) ? text_toast_default_error_header : config.header,
    headerClass: is_null(config.headerClass) ? "bg-danger text-light border-0" : config.headerClass,
    body: is_null(config.body) ? text_toast_default_error_body : config.body,
    closeButton: is_null(config.closeButton) ? true : config.closeButton,
    closeButtonLabel: is_null(config.closeButtonLabel) ? "close" : config.closeButtonLabel,
    closeButtonClass: is_null(config.closeButtonClass) ? "" : config.closeButtonClass,
    toastClass: is_null(config.toastClass) ? "bg-danger text-light border-0" : config.toastClass,
    icon: is_null(config.icon) ? "bi bi-exclamation-octagon me-1" : config.icon,
    animation: is_null(config.animation) ? true : config.animation,
    delay: is_null(config.delay) ? 2000 : config.delay,
    position: is_null(config.position) ? "top-0 end-0" : config.position,
    direction: is_null(config.direction) ? "append" : config.direction,
    ariaLive: is_null(config.ariaLive) ? "assertive" : config.ariaLive,
  };
  // Display error toast with default configuration
  bootstrap.showToast(default_config);
  // Redirect or reload after toast is hidden, if specified
  redirectAfterToast(url, isReload);
}

// Function to handle redirect or reload after toast is hidden, based on specified parameters.
function redirectAfterToast(url, isReload) {
  if (!is_null(isReload) && isReload == true) {
    // Reload page after toast is hidden
    $('.toast').on('hidden.bs.toast', function () {
      window.location.reload();
    });
  }
  else if (!is_null(url)) {
    // Redirect to specified URL after toast is hidden
    $('.toast').on('hidden.bs.toast', function () {
      window.location.href = url;
    });
  }
}

/**
 * Setting Active Menu : Function to display a activ menu.
 * menuActive : from javascript.php (controller)
 */
function setActiveMenu() {
    if (!is_null(menuActive)) {
    const navlinks = [...document.querySelectorAll('.sidebar a.nav-link')];
    navlinks.forEach(navlink => {
      // check active menu
      const data_menu = navlink.getAttribute('data-menu');
      if (menuActive.some(mn => parseInt(mn.mn_seq) === parseInt(data_menu))) {
        navlink.classList.add('active')

        // menu full bar
        if (!document.querySelector('body').classList.contains('toggle-sidebar')) {
          navlink.classList.remove('collapsed')
          if (navlink.hasAttribute('data-bs-target')) {
            const collapseElement = document.querySelector(navlink.getAttribute('data-bs-target'))
            collapseElement.classList.add('show')
          }
        }
      }
    });

    const alinks = [...document.querySelectorAll('.sidebar ul li a')];
    alinks.forEach(alink => {
      // check active menu
      const data_menu = alink.getAttribute('data-menu');
      if (menuActive.some(mn => parseInt(mn.mn_seq) === parseInt(data_menu))) {
        alink.classList.add('active')
      }
    });
  }
}

function addMonthNavigationListeners() {
  const calendar = document.querySelector('.flatpickr-calendar');
  if (calendar) {
      const prevButton = calendar.querySelector('.flatpickr-prev-month');
      const nextButton = calendar.querySelector('.flatpickr-next-month');
      if (prevButton && nextButton) {
          prevButton.addEventListener('click', function() {
              setTimeout(convertYearsToThai, 0);
          });
          nextButton.addEventListener('click', function() {
              setTimeout(convertYearsToThai, 0);
          });
      }
  }
}

function initializeDataTable(selector, data, columns) {
  
   // Destroy existing DataTable if it exists
   if ($.fn.DataTable.isDataTable(selector)) {
    $(selector).DataTable().clear().destroy();
  }

  return new DataTable(selector, {
      data: data,
      columns: columns,
      language: {
          decimal: "",
          emptyTable: "ไม่มีรายการในระบบ",
          info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
          infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
          infoFiltered: "(filtered from _MAX_ total entries)",
          infoPostFix: "",
          thousands: ",",
          lengthMenu: "_MENU_",
          loadingRecords: "Loading...",
          processing: "",
          search: "",
          searchPlaceholder: 'ค้นหา...',
          zeroRecords: "ไม่พบรายการ",
          paginate: {
              first: "«",
              last: "»",
              next: "›",
              previous: "‹"
          },
          aria: {
              orderable: "Order by this column",
              orderableReverse: "Reverse order this column"
          }
      },
      dom: 'lBfrtip',
      buttons: [{
          extend: 'print',
          text: '<i class="bi-file-earmark-fill"></i> Print',
          titleAttr: 'Print',
          title: 'รายการข้อมูล'
      },
      {
          extend: 'excel',
          text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
          titleAttr: 'Excel',
          title: 'รายการข้อมูล'
      },
      {
          extend: 'pdf',
          text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
          titleAttr: 'PDF',
          title: 'รายการข้อมูล',
          "customize": function (doc) {
              doc.defaultStyle = { font: 'THSarabun' };
          }
      }],
      initComplete: function() {
          var api = this.api();
          api.on('draw', function() {
              if (api.rows({ filter: 'applied' }).data().length === 0) {
                  $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
              }
          });
      }
  });
}

// Function to initialize select2
function initializeSelect2(selector) {
  $(selector).select2({
      theme: "bootstrap-5",
      width: '100%', // Set width to 100%
      placeholder: 'Select...', // Optional placeholder
      allowClear: true // Optional allow clear
  });
}

function setInvalidInput(error_inputs) {
  const errors = Object.entries(error_inputs);
  if (errors.length > 0) {
      for (const [key, value] of Object.entries(errors)) {
          var val = value[1];
          var input_errors = [...document.querySelectorAll('input[name="' + val['name'] + '"]')];
          input_errors.forEach(in_er => {
              // Find the next element with a specific class
              var div_invalid = in_er.nextElementSibling;
              if (div_invalid && div_invalid.classList.contains('invalid-feedback')) {
                  div_invalid.innerHTML = val['error'];
              }
              in_er.classList.add('is-invalid')
          });
          
          var select2_errors = [...document.querySelectorAll('select[name="' + val['name'] + '"] + .select2-container')];
          // var select_errors = [...document.querySelectorAll('select[name="' + val['name'] + '"]')];
          select2_errors.forEach(sl_er => {
              // Find the next element with a specific class
              var div_invalid = sl_er.nextElementSibling;
              if (div_invalid && div_invalid.classList.contains('invalid-feedback')) {
                  div_invalid.innerHTML = val['error'];
              }
              sl_er.classList.add('is-invalid');

              var child = sl_er.children;
              child = child[0].children[0];
              child.classList.add('is-invalid');
          });

          var select2_by_iderrors = [...document.querySelectorAll('select[id="' + val['name'] + '"] + .select2-container')];
          // var select_errors = [...document.querySelectorAll('select[name="' + val['name'] + '"]')];
          select2_by_iderrors.forEach(sl_er => {
              // Find the next element with a specific class
              var div_invalid = sl_er.nextElementSibling;
              if (div_invalid && div_invalid.classList.contains('invalid-feedback')) {
                  div_invalid.innerHTML = val['error'];
              }
              sl_er.classList.add('is-invalid');

              var child = sl_er.children;
              child = child[0].children[0];
              child.classList.add('is-invalid');
          });
      }
  }
}

function setTooltipDefault(selector = ".option button") {
  const td_options = [...document.querySelectorAll(selector)];
  // console.log("td_options ", td_options);
  Array.from(td_options).forEach(btn => {
    const title = btn.getAttribute('title');
    btn.setAttribute('data-bs-toggle', 'tooltip');
    btn.setAttribute('data-bs-placement', 'top');
    // title case
    if (btn.classList.contains('btn-warning')) {
      btn.setAttribute('title', is_null(title) ? 'แก้ไขข้อมูล' : title);
    } else if (btn.classList.contains(is_null(title) ? 'btn-success' : title)) {
      btn.setAttribute('title', 'เพิ่มข้อมูล');
    } else if (btn.classList.contains(is_null(title) ? 'btn-danger' : title)) {
      btn.setAttribute('title', 'ลบข้อมูล');
    } else if (btn.classList.contains(is_null(title) ? 'btn-success' : title)) {
      btn.setAttribute('title', 'จัดการข้อมูล');
    }
    new bootstrap.Tooltip(btn);
  });
}

function save_ajax(url, selector, formData) {
  let form = document.getElementById(selector);

  if (form.checkValidity()) {
      clear_input_invalid();
      $.ajax({
          url: url,
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(data) {
              if (data.data.status_response == status_response_success) {
                  dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, data.data.returnUrl, false);
              } else if (data.data.status_response == status_response_error) {
                  if (!is_null(data.data.error_inputs)) {
                    setInvalidInput(data.data.error_inputs);
                  }

                  if (!is_null(data.data.message_dialog))
                      dialog_error({ 'header': text_toast_save_error_header, 'body': data.data.message_dialog });
                  else
                      dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
              }
          }
      });
  }
  
  form.classList.add('was-validated')
}