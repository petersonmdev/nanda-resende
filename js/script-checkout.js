(function($) {
    console.log("testando");

    $('button.success').click(function () {
        alertify.set({
            delay: 1700
        });
        alertify.success("Success notification");
    });

    $('button.alert').click(function () {
        alertify.set({
            delay: 1700
        });
        alertify.error("Error notification");
    });

    jQuery(document).ready(function(c) {
        c(".pricing-selector li").on("click", function(e) {
            c(".pricing-selector li").removeClass("selected"), c(this).addClass("selected")
        })
    });

    function verifica_cpf_cnpj(l) {
        return 11 === (l = (l = l.toString()).replace(/[^0-9]/g, "")).length ? "CPF" : 14 === l.length && "CNPJ"
    }

    function calc_digitos_posicoes(l, e, i) {
        "" != e && null != e || (e = 10), "" != i && null != i || (i = 0), l = l.toString();
        for (var t = 0; t < l.length; t++) i += l[t] * e, --e < 2 && (e = 9);
        return l + (i = (i %= 11) < 2 ? 0 : 11 - i)
    }

    function valida_cpf(l) {
        var e = calc_digitos_posicoes((l = (l = l.toString()).replace(/[^0-9]/g, "")).substr(0, 9));
        return (e = calc_digitos_posicoes(e, 11)) === l
    }

    function valida_cnpj(l) {
        var e = l = (l = l.toString()).replace(/[^0-9]/g, "");
        return calc_digitos_posicoes(calc_digitos_posicoes(l.substr(0, 12), 5), 6) === e
    }

    function valida_cpf_cnpj(l) {
        var e = verifica_cpf_cnpj(l);
        return l = (l = l.toString()).replace(/[^0-9]/g, ""), "CPF" === e ? valida_cpf(l) : "CNPJ" === e && valida_cnpj(l)
    }

    function formata_cpf_cnpj(l) {
        var e = !1,
            i = verifica_cpf_cnpj(l);
        return l = (l = l.toString()).replace(/[^0-9]/g, ""), "CPF" === i ? valida_cpf(l) && (e = l.substr(0, 3) + ".", e += l.substr(3, 3) + ".", e += l.substr(6, 3) + "-", e += l.substr(9, 2) + "") : "CNPJ" === i && valida_cnpj(l) && (e = l.substr(0, 2) + ".", e += l.substr(2, 3) + ".", e += l.substr(5, 3) + "/", e += l.substr(8, 4) + "-", e += l.substr(12, 14) + ""), e
    }

    jQuery(document).ready(function ($) {

        /* MÁSCARAS DE CAMPOS E VALIDAÇÕES DO CHECKOUT */

        /**** variaveis para validação de campos */
        var name_hasError = null,
            last_name_hasError = null,
            cpf_hasError = null,
            phone_hasError = null,
            cep_hasError = null;


        /**** MÁSCARAS DE CAMPO */
        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, "").length === 11 ? "(00) 00000-0000" : "(00) 0000-00009";
            },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $("#billing_cpf").mask("000.000.000-00");
        $("#billing_postcode").mask("00000-000");
        $("#billing_phone").mask(SPMaskBehavior, spOptions);


        /**** VALIDAÇÃO DE NOMES */
        $("#billing_first_name").blur(function (event) {
            var name = $(this).val();
            var len = name.length;
            if (len < 2) {
                $("#billing_first_name").css("border-color", "red");
                name_hasError = 1;
            }
            else {
                $("#billing_first_name").css("border-color", "#0f834d");
                name_hasError = 0;
            }
        });
        $("#billing_last_name").blur(function (event) {
            var lastname = $(this).val();
            var len = lastname.length;
            if (len < 2) {
                $("#billing_last_name").css("border-color", "red");
                last_name_hasError = 1;
            }
            else {
                $("#billing_last_name").css("border-color", "#0f834d");
                last_name_hasError = 0;
            }
        });


        /****** VERIFICAÇÃO DE CPF *****/
        var validaCpf = {
            go: function (cpf) {
                if (cpf.length > 0 && cpf.length < 14) {
                    alertify.set({
                        delay: 1700
                    });
                    alertify.error("cpf inválido!");
                    $("#billing_cpf").css("border-color", "red");
                    $("#billing_cpf").val("").focus();
                    $("#billing_cpf").attr("placeholder", "Digite seu cpf válido");
                    cpf_hasError = 1;
                    return;
                }

                if (cpf.length === 14) {
                    if (valida_cpf_cnpj(cpf)) {
                        $("#billing_cpf").css("border-color", "#0f834d");
                        cpf_hasError = 0;
                    } else {
                        alertify.set({
                            delay: 1700
                        });
                        alertify.error("cpf inválido!");
                        $("#billing_cpf").css("border-color", "red");
                        $("#billing_cpf").val("").focus();
                        $("#billing_cpf").attr("placeholder", "CPF Inválido");
                        cpf_hasError = 1;
                    }
                }

            }
        };


        $("#billing_cpf").change(function () {
            var cpf = $("#billing_cpf").val();
            validaCpf.go(cpf);
        });


        ////////////////////////////
        ///////***** VERIFICAÇÃO DE TELEFONE *****
        ///////////////////
        var validaPhone = {
            go: function (phone) {
                if (phone.length < 14) {
                    $("#billing_phone").css("border-color", "red");
                    $("#billing_phone").val("").focus();
                    $("#billing_phone").attr("placeholder", "Telefone Inválido");
                    phone_hasError = 1;
                }
                else {
                    $("#billing_phone").css("border-color", "#0f834d");
                    phone_hasError = 0;
                }
            }
        };

        // if($("#billing_phone").val() != ""){
        //     var phone = $("#billing_phone").val();
        //     validaPhone.go(phone);
        // }
        $("#billing_phone").change(function () {
            var phone = $("#billing_phone").val();
            validaPhone.go(phone);
        });

        ////////////////////////////
        ///////***** VERIFICAÇÃO E AUTOCOMPLETE DE CEP *****
        ///////////////////

        var validaCep = {
            go: function (cep, len) {
                if (len === 9) {
                    $.get("https://viacep.com.br/ws/" + cep + "/json", function (data) {
                        if (data.erro == true) {
                            alertify.set({
                                delay: 1700
                            });
                            alertify.error("CEP inválido!");
                            $("#billing_postcode").css("border-color", "red");
                            $("#billing_postcode").attr("placeholder", "Cep Inválido");
                            $("#billing_postcode").val("").focus();
                            return;
                        }
                        autofillCep.go(data);
                    });
                }
            }
        };

        var autofillCep = {
            go: function (data) {
                $("#billing_postcode").css("border-color", "#0f834d");

                $("#billing_address_1").val(data.logradouro);
                $("#billing_address_1").css("border-color", "#0f834d");

                if ($("#billing_number").val() != "")
                    $("#billing_number").css("border-color", "#0f834d");

                $("#billing_neighborhood").val(data.bairro);
                $("#billing_neighborhood").css("border-color", "#0f834d");

                $("#billing_city").css("border-color", "#0f834d");
                $("#billing_city").val(data.localidade);

                $("#billing_state option[value=" + data.uf + "]").prop("selected", true);
                $("#select2-billing_state-container").attr("title", data.uf);
                $("#select2-billing_state-container").html(data.uf);
                $(".select2-selection--single").css("border-color", "#0f834d");
                $("#billing_state option").each(function () {
                    if ($(this).val() == data.uf) {
                        $(this).prop("selected", true);
                    }
                });
                cep_hasError = 0;

                $("#billing_number").attr('type', 'number');
                $("#billing_number").focus();
            }
        };


        $("#billing_postcode").keyup(function (event) {
            var cep = $("#billing_postcode").val();
            var len = cep.length;
            if (len === 9) {
                validaCep.go(cep, len);
            }
        });


        //var url = window.location.href;
        var url = window.location.href;
        if (url.indexOf('finalizar-compra') >= 0) {

            var name = $("#billing_first_name").val();
            var lastname = $("#billing_first_name").val();
            if (name.length >= 2) {
                $("#billing_first_name").css("border-color", "#0f834d");
            }
            if (lastname.length >= 2) {
                $("#billing_last_name").css("border-color", "#0f834d");
            }
            /** Validação de dados quando logado */
            if ($("#billing_cpf").val() != "") {
                var cpf = $("#billing_cpf").val();
                validaCpf.go(cpf);
            }
            if ($("#billing_postcode").val() != "") {
                var cep = $("#billing_postcode").val();
                var len = cep.length;
                validaCep.go(cep, len);
            }
            if ($("#billing_phone").val() != "") {
                var phone = $("#billing_phone").val();
                validaPhone.go(phone);
            }
            if ($("#billing_email").val() != "") {
                $("#billing_email").css("border-color", "#0f834d");
            }

        }

        // ******* FIM DA VALIDAÇÃO DE CEP *******************




        $(".button-tabs").click(function (event) {
            event.preventDefault();
            var item = $(this).attr("id");
            $(".tab-child").hide();
            $("#" + item).show();

            switch ($(this).attr("data-tab")) {
                case "tab-one":
                    changeTabs.go($(this).attr("data-tab"), "#btn-cart", "#btn-two");

                    $(".ball").removeClass("active");
                    $("#checkout-step1").addClass("active");
                    $("#icon-seta-step-left").css("display", "none");
                    $("#icon-seta-step-right").css("display", "inline-block");
                    $("#btn-two").removeClass("last-step");
                    break;
                case "tab-two":
                    validateForm.validate($(this).attr("data-tab"), "#btn-one", "#btn-three");

                    $(".ball").removeClass("active");
                    $("#checkout-step1").addClass("active");
                    $("#checkout-step2").addClass("active");

                    var endereco = $("#billing_address_1").val();
                    var numero = $("#billing_number").val();
                    var bairro = $("#billing_neighborhood").val();
                    var cidade = $("#billing_city").val();
                    var estado = $("#select2-billing_state-container").text();

                    var string = "<p><strong>Endereço:</strong> " + endereco + "</p> <p><strong>Número:</strong> " + numero + "</p> <p><strong>Bairro:</strong> " + bairro + "</p> <p><strong>Cidade/UF:</strong> " + cidade + "/" + estado + "</p>";
                    $("#local-de-entrega").html(string);

                    break;
                case "tab-three":
                    changeTabs.go($(this).attr("data-tab"), "#btn-two", "#btn-checkout");

                    $(".ball").removeClass("active");
                    $("#checkout-step1").addClass("active");
                    $("#checkout-step2").addClass("active");
                    $("#checkout-step3").addClass("active");
                    $("#icon-seta-step-right").css("display", "none");
                    $("#icon-seta-step-left").css("display", "inline-block");
                    $("#btn-two").addClass("last-step");
                    break;
                default:
                    alertify.set({
                        delay: 1700
                    });
                    alertify.error("Error!");
                    break;
            }

        });

        var changeTabs = {
            go: function (tab, btnleft, btnright) {
                $(".tab-child").hide();
                $("#" + tab).show();
                $("#checkout-step-buttons a").hide();
                $(btnleft).show().css("float", "left"); //$(btnleft);
                $(btnright).show().css("float", "right"); //$(btnright);
            }
        };

        var validateForm = {
            validate: function (tab, btnleft, btnright) {
                changeTabs.go(tab, btnleft, btnright);
                if ($("#checkout-form").attr("data-status") == "loged") {
                    changeTabs.go(tab, btnleft, btnright);
                    $("#checkout-step1").addClass("active");
                    $("#checkout-step2").addClass("active");
                } else {
                    if (
                        name_hasError == 0 &&
                        last_name_hasError == 0 &&
                        cpf_hasError == 0 &&
                        phone_hasError == 0 &&
                        cep_hasError == 0 &&
                        $("#billing_cpf").val() != '' &&
                        $("#billing_postcode").val() != '' &&
                        $("#billing_address_1").val() != '' &&
                        $("#billing_number").val() != '' &&
                        $("#billing_neighborhood").val() != '' &&
                        $("#billing_city").val() != ''
                    ) {
                        changeTabs.go(tab, btnleft, btnright);
                        $(".ball").removeClass("active");
                        $("#checkout-step1").addClass("active");
                        $("#checkout-step2").addClass("active");
                    }
                    else {
                        //changeTabs.go( tab, btnleft, btnright )
                        changeTabs.go("tab-one", "#btn-cart", "#btn-two");
                        alertify.set({
                            delay: 3000
                        });
                        alertify.error("Um ou mais campos não foram preenchidos corretamente!");
                        console.log(
                            { "name": name_hasError, "lastname": last_name_hasError, "cpf": cpf_hasError, "phone": phone_hasError, "cep": cep_hasError }
                        );
                    }
                }
            }
        };
    });

    jQuery(document).ready(function ($) {
        $("#checkout-form tr.woocommerce-shipping-totals > th").remove();
        $("#checkout-form input[type='radio']").css({ "opacity": "0" });


        $("#billing_number").attr('type', 'number');

    });

})(window.jQuery);