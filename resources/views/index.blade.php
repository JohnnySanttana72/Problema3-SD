<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />



  <!-- load CSS -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" />
  <!-- Google web font "Open Sans" -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <!-- https://getbootstrap.com/ -->
  <link rel="stylesheet" href="slick/slick.css" />
  <link rel="stylesheet" href="slick/slick-theme.css" />
  <link rel="stylesheet" href="css/magnific-popup.css" />
  <link rel="stylesheet" href="css/tooplate-style.css" />
  <!-- Templatemo style -->

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item">

    </li>
    <li class="nav-item">
      <a class="nav-link active">
        <i class="fa fa-microchip"></i>

        <span class="badge badge-pill badge-danger" id="status_dispositivo" style="margin-left: 7px;">Offline</span>
      </a>
    </li>
  </ul>
  </nav>


  <div class="tm-main-container">
    <div class="tm-top-container">
      <!-- Menu -->
      <nav id="tmNav" class="tm-nav">
        <a class="tm-navbar-menu" href="#">Menu</a>
        <ul class="tm-nav-links">
          <li class="tm-nav-item active">
            <a href="#" data-linkid="0" data-align="right" class="tm-nav-link">Home</a>

          <li class="tm-nav-item">
            <a href="#" data-linkid="1" data-align="left" class="tm-nav-link">Configuração</a>
          </li>

          <li class="tm-nav-item">
            <a href="#" data-linkid="3" data-align="left" class="tm-nav-link">Contato</a>
          </li>

          <li class="tm-nav-item">
            <a href="#" data-linkid="4" data-align="left" class="tm-nav-link">Histórico</a>
          </li>

          <li class="tm-nav-item">
            <a href="#" data-linkid="5" data-align="left" class="tm-nav-link">Acidente</a>
          </li>

        </ul>
      </nav>

      <!-- Site header -->
      <header class="tm-site-header-box tm-bg-dark">
        <h1 class="tm-site-title">Monitoramento</h1>
        <p class="mb-0 tm-site-subtitle">Sua segurança em boas mãos</p>
      </header>
    </div>
    <!-- tm-top-container -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Site content -->
          <div class="tm-content">
            <!-- Section 0 Introduction -->
            <section class="tm-section tm-section-0 tm-section-personalizada">
              <h2 class="tm-section-title mb-3 font-weight-bold">
                Introdução
              </h2>
              <div class="tm-textbox tm-bg-dark">
                <p>
                  Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reiciendis eligendi, dolores fuga fugit
                  molestias aperiam cupiditate magni consequuntur mollitia quae, libero quasi! Vel, doloribus at. Velit,
                  veritatis. Voluptatibus, ad architecto?
                </p>
                <p class="mb-0">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse doloremque, repudiandae officiis optio
                  ex dolor sint earum corrupti placeat. Temporibus aspernatur nesciunt voluptas! Dolorem natus odit
                  soluta corporis autem labore.
                </p>
              </div>
              <a href="#" id="tm_about_link" data-linkid="3" class="tm-link">Contato emergência</a>
            </section>



            <!-- Section 1 About Me -->
            <section class="tm-section tm-section-1 tm-section-personalizada">
              <div class="tm-textbox tm-textbox-2 tm-bg-dark">
                <h2 class="tm-text-blue mb-1">Configuração de notificação</h2>
                <p class="mb-4">
                  Escolha o periodo que deseja não receber notificação.
                </p>
                <p class="mb-1"></p>

                <label for="appt"></label>

                <input type="time" id="appt" name="appt" min="09:00" max="18:00" style="padding: 12px 30px;
    font-size: 18px;" required>
                <a href="#" id="tm_work_link" data-linkid="1" class="tm-link m-0">Salvar</a>
              </div>
            </section>

            <!-- Section 3 Contact -->
            <section class="tm-section tm-section-3 tm-section-left tm-section-personalizada">
              <form action="" class="tm-contact-form" id="form-contato">
                <div class="form-group mb-4">
                  <input type="text" id="contact_name" name="contact_name" class="form-control" placeholder="Name"
                    @if(isset($contato)) value={{ $contato->name }} @endif
                  required />
                </div>
                <div class="form-group mb-4">
                  <input type="email" id="contact_email" name="contact_email" class="form-control" @if(isset($contato))
                    value={{ $contato->email }} @endif placeholder="Email"
                  required />
                </div>
                <!-- <div class="form-group mb-4">
                  <textarea rows="4" id="contact_message" name="contact_message" class="form-control"
                    placeholder="Message" required></textarea>
                </div> -->
                <div class="form-group mb-0">
                  <button type="button" class="btn tm-send-btn tm-fl-right atualizar">
                    Atualizar
                  </button>
                </div>

              </form>

            </section>

          </div>

          <div style="padding-bottom: 50px;justify-content: center;width: 100%;">
            <!-- Section 4 Historico -->
            <section class="tm-section tm-section-4" style="margin-right: 0px;">
              <div class="row justify-content-center">
                <div class="col">
                  <table class="table table-bordered" style="background: rgba(0, 0, 0, 0.7);" width="100%">
                    <thead>
                      <tr>
                        <th width="25%">Data e Hora</th>
                        <th width="37%">Estado</th>
                        <th width="37%">Houve acidente</th>
                      </tr>
                    </thead>

                    <tbody id="table-body">
                      @foreach($dadosLog as $log)
                      <tr>
                        <td id="data">{{\Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i')}}</td>
                        <td id="estado">{{$log->estado}}</td>
                        @if($log->acidente)
                        <td id="acidente">{{$log->acidente}}</td>
                        @else
                        <td id="acidente"> - </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>


                  </table>
                </div>
              </div>

            </section>

            <section class="tm-section tm-section-5" style="margin-right: 0px;">
              <div class="tm-textbox tm-textbox-2 tm-bg-dark" id="section-acidente">
                <h2 class="tm-text-blue mb-1" style="text-align:center">Informe que está em segurança</h2>
                <p class="mb-4" style="text-align:center">Aperte o botão para sabermos que está bem</p>
                <p class="mb-1"></p>
                <div class="form-group">
                  <label for="appt"></label>

                  <input type="time" id="timer_count" name="appt" value="00:00" style="padding: 12px 30px;
    font-size: 18px;
    margin-left: 50%;
    " readonly>
                </div>
                <div style="
    margin-left: 50%;">
                  <button id="tm_work_link" class="tm-link m-0 btn stop-timer" style="
    background: #00ccfc;
    color: white;
" disabled>Estou Seguro</button>
                  <button id="tm_work_link" class="tm-link m-0 btn reset-placa" style="
    background: #00ccfc;
    color: white;
" disabled>Resetar Placa</a>
                </div>
              </div>

            </section>
          </div>
        </div>
      </div>
    </div>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/background.cycle.js"></script>
    <script src="slick/slick.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script>
      let slickInitDone = false;
      let previousImageId = 0,
        currentImageId = 0;
      let pageAlign = "right";
      let bgCycle;
      let links;
      let eachNavLink;

      window.onload = function () {
        $("body").addClass("loaded");
      };

      function navLinkClick(e) {
        if ($(e.target).hasClass("external")) {
          return;
        }

        e.preventDefault();

        if ($(e.target).data("align")) {
          pageAlign = $(e.target).data("align");
        }

        // Change bg image
        previousImageId = currentImageId;
        currentImageId = $(e.target).data("linkid");
        bgCycle.cycleToNextImage(previousImageId, currentImageId);

        // Change menu item highlight
        $(`.tm-nav-item:eq(${previousImageId})`).removeClass("active");
        $(`.tm-nav-item:eq(${currentImageId})`).addClass("active");

        // Change page content
        $(`.tm-section-${previousImageId}`).fadeOut(function (e) {
          $(`.tm-section-${currentImageId}`).fadeIn();
          // Gallery
          if (currentImageId === 2) {
            setupSlider();
          }
        });

        adjustFooter();
      }

      $(document).ready(function () {
        // Set first page
        $(".tm-section").fadeOut(0);
        $(".tm-section-0").fadeIn();

        // Set Background images
        // https://www.jqueryscript.net/slideshow/Simple-jQuery-Background-Image-Slideshow-with-Fade-Transitions-Background-Cycle.html
        bgCycle = $("body").backgroundCycle({
          imageUrls: [
            "img/pexels-javier-aguilera-2611684.jpg",
            "img/photo-02.jpg",
            "img/photo-04.jpg",
            "img/photo-05.jpg",
            "img/photo-05.jpg"
          ],
          fadeSpeed: 2000,
          duration: -1,
          backgroundSize: SCALING_MODE_COVER
        });

        eachNavLink = $(".tm-nav-link");
        links = $(".tm-nav-links");

        // "Menu" open/close
        if (links.hasClass("open")) {
          links.fadeIn(0);
        } else {
          links.fadeOut(0);
        }

        $("#tm_about_link").on("click", navLinkClick);
        $("#tm_work_link").on("click", navLinkClick);

        // Each menu item click
        eachNavLink.on("click", navLinkClick);

        $(".tm-navbar-menu").click(function (e) {
          if (links.hasClass("open")) {
            links.fadeOut();
          } else {
            links.fadeIn();
          }

          links.toggleClass("open");
        });

        // window resize
        $(window).resize(function () {
          // If current page is Gallery page, set it up
          if (currentImageId === 2) {
            setupSlider();
          }

          // Adjust footer
          adjustFooter();
        });

        adjustFooter();
      }); // DOM is ready

      function adjustFooter() {
        const windowHeight = $(window).height();
        const topHeight = $(".tm-top-container").height();
        const middleHeight = $(".tm-content").height();
        let contentHeight = topHeight + middleHeight;

        if (pageAlign === "left") {
          contentHeight += $(".tm-bottom-container").height();
        }

        if (contentHeight > windowHeight) {
          $(".tm-bottom-container").addClass("tm-static");
        } else {
          $(".tm-bottom-container").removeClass("tm-static");
        }
      }

      function setupSlider() {
        let slidesToShow = 5;
        let slidesToScroll = 2;
        let windowWidth = $(window).width();

        if (windowWidth < 480) {
          slidesToShow = 1;
          slidesToScroll = 1;
        } else if (windowWidth < 768) {
          slidesToShow = 2;
          slidesToScroll = 1;
        } else if (windowWidth < 992) {
          slidesToShow = 3;
          slidesToScroll = 2;
        }

        if (slickInitDone) {
          $(".tm-gallery").slick("unslick");
        }

        slickInitDone = true;

        $(".tm-gallery").slick({
          dots: true,
          customPaging: function (slider, i) {
            var thumb = $(slider.$slides[i]).data();
            return `<a>${i + 1}</a>`;
          },
          infinite: true,
          prevArrow: false,
          nextArrow: false,
          slidesToShow: slidesToShow,
          slidesToScroll: slidesToScroll
        });

        // Open big image when a gallery image is clicked.
        $(".slick-list").magnificPopup({
          delegate: "a",
          type: "image",
          gallery: {
            enabled: true
          }
        });
      }
    </script>

    <script type="text/javascript">
      $(document).ready(function () {
        estadoPlaca()
        subscribe("$aws/things/NodeMCU/shadow/update");
      });

      function estadoPlaca() {

        $.ajax({
          url: 'https://g84sc7hsu1.execute-api.us-east-1.amazonaws.com/monitoramento/estado',
          type: "GET",
          dataType: 'JSON',
          success: function (res) {
            console.log(res.estado);

            if (res.estado == 'CONECTADO') {
              $('#status_dispositivo').attr('class', 'badge badge-pill badge-success');
              $('#status_dispositivo').text('Online');
              logPlaca("estado", "CONECTADO");
            } else if (res.estado == 'DESCONECTADO') {
              $('#status_dispositivo').attr('class', 'badge badge-pill badge-danger');
              $('#status_dispositivo').text('Offline');
              logPlaca("estado", "DESCONECTADO", null);
            }
           
            // time_subscribe = setTimeout(function () {
            //     subscribe(topic)
            // }, 7000);
          }
        });
      }

      var time_out;
      var tempo

      function subscribe(topic) {
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          url: '/subscribeMqtt',
          type: "POST",
          data: {
            topic: topic,
            _token: _token
          },
          dataType: 'JSON',
          cache: false,
          success: function (res) {
            console.log(res.resultado);

            var obj2 = JSON.parse(res.resultado.message);


            if (obj2.state.reported.acidente) {
              console.log("Tempo de execução: " + res.tempo_de_execucao_ms);
              var acidente = obj2.state.reported.acidente;
              console.log(acidente, $('#status_dispositivo').text());

              $('.stop-timer').prop("disabled", false);
              tempo = 60
              countdown()
              // alert("Aconteceu um acidente? Caso esteja tudo bem vá até a aba de Acidente e confirme se está tudo bem!")
              toastr.error('Aconteceu um acidente? Caso esteja tudo bem vá até a aba de Acidente e confirme se está tudo bem!')
              
              // logPlaca("acidente", acidente, $('#status_dispositivo').text());
            }


            /*$('#status_dispositivo').attr('class', 'badge badge-pill badge-success');
            $('#status_dispositivo').text('Online');

            $(".send-hour").prop("disabled", false);

            $(".send-timer").prop("disabled", false);

            $('.cube-switch .switch').css('pointer-events', 'auto');
            $('.cube-switch').css('background', '#666');
            $('.cube-switch .switch').css('background', '#333');*/

            time_subscribe = setTimeout(function () {
              subscribe(topic)
            }, 2000);
          },
          statusCode: {
            500: function () {
              console.log('reconnect');
              /*$('#status_dispositivo').attr('class', 'badge badge-pill badge-danger');
              $('#status_dispositivo').text('Offline');

              $(".send-hour").prop("disabled", true);

              $(".send-timer").prop("disabled", true);

              $('.cube-switch .switch').css('pointer-events', 'none');
              $('.cube-switch').css('background', '#7c7c7d');
              $('.cube-switch .switch').css('background', '#7c7c7d');

              if ($('.cube-switch').hasClass('active')) {
                  $('.cube-switch').removeClass('active');
                  $('#light-bulb2').css({ 'opacity': '0' });
              }*/

              subscribe(topic)
            }
          },
        });
      }

      $('.stop-timer').click(function (event) {
        $('.stop-timer').prop("disabled", true);
        $('.reset-placa').prop("disabled", false);
        $("#timer_count").val('00:00');
        clearTimeout(time_out)
      })

      function countdown() {
        // Se o tempo não for zerado
        if ((tempo - 1) >= -1) {

          // var hours = Math.floor(tempo/3600);
          var min = Math.floor(Math.floor(tempo) / 60);
          var seg = tempo % 60;

          // Pega a parte inteira dos minutos
          //var min = parseInt(tempo / 60);
          // Calcula os segundos restantes
          //var seg = tempo % 60;

          // Formata o número menor que dez, ex: 08, 07, ...
          // if (min < 10) {
          //     min = "0" + min;
          //     min = min.substr(0, 2);
          // }
          // if (seg <= 9) {
          //     seg = "0" + seg;
          // }
          function pad(n) {
            return (n < 10 ? "0" + n : n);
          }

          // Cria a variável para formatar no estilo hora/cronômetro
          horaImprimivel = pad(min) + ':' + pad(seg);;
          //JQuery pra setar o valor
          $("#timer_count").val(horaImprimivel);

          // Define que a função será executada novamente em 1000ms = 1 segundo
          time_out = setTimeout('countdown()', 1000);

          if (tempo == 0) {
          
            $('.stop-timer').prop("disabled", true);
            $('.reset-placa').prop("disabled", false);
            logPlaca("acidente", acidente, $('#status_dispositivo').text());
          }

          // diminui o tempo
          tempo--;

          // Quando o contador chegar a zero faz esta ação
        }
        else {
          $('#myAlert').show().fadeOut(5000);
        }
      }

      function logPlaca(type, dado, estado) {
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          url: '/logPlaca',
          type: "POST",
          async: true,
          data: {
            type: type,
            dado: dado,
            estado: estado,
            _token: _token
          },
          dataType: 'JSON',
          success: function (res) {
            console.log(res.log);
            $('#table-body').empty()
            if (isEmpty(res.log) == false) {
              var content_tabela = ``

              for (var i in res.log) {
                content_tabela += '<tr>'

                var date = new Date(res.log[i].created_at);

                var dateFormated = ("0" + date.getDate()).slice(-2) + "/" + ("0" + (date.getMonth() + 1)).slice(-2) + "/" +
                  date.getFullYear() + " " +
                  ("0" + date.getHours()).slice(-2) + ":" +
                  ("0" + date.getMinutes()).slice(-2);

                content_tabela += '<td id="data">' + dateFormated + '</td>'

                content_tabela += '<td id="estado">' + res.log[i].estado + '</td>'
                if (res.log[i].acidente != null) {
                  content_tabela += '<td id="acidente">' + res.log[i].acidente + '</td>'
                } else {
                  content_tabela += '<td id="acidente"> - </td>'
                }

                content_tabela + '</tr>'
              }

              $('#table-body').append(content_tabela);

            }
          },
          error: function (jqXHR, status, error) {
            console.log(error);
          }


        })
      }

      function isEmpty(obj) {
        for (var prop in obj) {
          if (obj.hasOwnProperty(prop))
            return false;
        }

        return true;
      }

      $('.atualizar').click(function (event) {
        event.preventDefault()
        console.log($("#form-contato").serializeArray())
        contatoAtualizar($("#form-contato").serializeArray())
      })

      function contatoAtualizar(dado) {
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          url: '/contatoAtualizar',
          type: "POST",
          async: true,
          data: {
            dado: dado,
            _token: _token
          },
          dataType: 'JSON',
          success: function (res) {
            console.log(res.contato);
            $('input[name=contact_name').val(res.contato.nome)
            $('input[name=contact_email').val(res.contato.email)
          },
          error: function (jqXHR, status, error) {
            console.log(error);
          }


        })
      }

      $('.reset-placa').click(function() {
        $('.reset-placa').prop("disabled", true);
        publish('reiniciar')
      })

      function publish(dado) {

        let _token = $('meta[name="csrf-token"]').attr('content');


        $.ajax({
            url: '/publishMqtt',
            type: "POST",
            data: {
                dado: dado,
                _token: _token
            },
            dataType: 'JSON',
            success: function (res) {
                console.log(res)
            },
            statusCode: {
                500: function () {
                  console.log('Dispositivo não está disponível');
                
                }
            }
        });
    }

    </script>
</body>

</html>