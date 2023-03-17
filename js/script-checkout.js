$(document).foundation();

/*global define*/
(function (global, undefined) {
    "use strict";

    var document = global.document,
        Alertify;

    Alertify = function () {

        var _alertify = {},
            dialogs = {},
            isopen = false,
            keys = {
                ENTER: 13,
                ESC: 27,
                SPACE: 32
            },
            queue = [],
            $, btnCancel, btnOK, btnReset, btnResetBack, btnFocus, elCallee, elCover, elDialog, elLog, form, input, getTransitionEvent;

        /**
         * Markup pieces
         * @type {Object}
         */
        dialogs = {
            buttons: {
                holder: "<nav class=\"alertify-buttons\">{{buttons}}</nav>",
                submit: "<button type=\"submit\" class=\"alertify-button alertify-button-ok\" id=\"alertify-ok\">{{ok}}</button>",
                ok: "<button class=\"alertify-button alertify-button-ok\" id=\"alertify-ok\">{{ok}}</button>",
                cancel: "<button class=\"alertify-button alertify-button-cancel\" id=\"alertify-cancel\">{{cancel}}</button>"
            },
            input: "<div class=\"alertify-text-wrapper\"><input type=\"text\" class=\"alertify-text\" id=\"alertify-text\"></div>",
            message: "<p class=\"alertify-message\">{{message}}</p>",
            log: "<article class=\"alertify-log{{class}}\">{{message}}</article>"
        };

        /**
         * Return the proper transitionend event
         * @return {String}    Transition type string
         */
        getTransitionEvent = function () {
            var t,
                type,
                supported = false,
                el = document.createElement("fakeelement"),
                transitions = {
                    "WebkitTransition": "webkitTransitionEnd",
                    "MozTransition": "transitionend",
                    "OTransition": "otransitionend",
                    "transition": "transitionend"
                };

            for (t in transitions) {
                if (el.style[t] !== undefined) {
                    type = transitions[t];
                    supported = true;
                    break;
                }
            }

            return {
                type: type,
                supported: supported
            };
        };

        /**
         * Shorthand for document.getElementById()
         *
         * @param  {String} id    A specific element ID
         * @return {Object}       HTML element
         */
        $ = function (id) {
            return document.getElementById(id);
        };

        /**
         * Alertify private object
         * @type {Object}
         */
        _alertify = {

            /**
             * Labels object
             * @type {Object}
             */
            labels: {
                ok: "OK",
                cancel: "Cancel"
            },

            /**
             * Delay number
             * @type {Number}
             */
            delay: 5000,

            /**
             * Whether buttons are reversed (default is secondary/primary)
             * @type {Boolean}
             */
            buttonReverse: false,

            /**
             * Which button should be focused by default
             * @type {String}	"ok" (default), "cancel", or "none"
             */
            buttonFocus: "ok",

            /**
             * Set the transition event on load
             * @type {[type]}
             */
            transition: undefined,

            /**
             * Set the proper button click events
             *
             * @param {Function} fn    [Optional] Callback function
             *
             * @return {undefined}
             */
            addListeners: function (fn) {
                var hasOK = (typeof btnOK !== "undefined"),
                    hasCancel = (typeof btnCancel !== "undefined"),
                    hasInput = (typeof input !== "undefined"),
                    val = "",
                    self = this,
                    ok, cancel, common, key, reset;

                // ok event handler
                ok = function (event) {
                    if (typeof event.preventDefault !== "undefined") event.preventDefault();
                    common(event);
                    if (typeof input !== "undefined") val = input.value;
                    if (typeof fn === "function") {
                        if (typeof input !== "undefined") {
                            fn(true, val);
                        } else fn(true);
                    }
                    return false;
                };

                // cancel event handler
                cancel = function (event) {
                    if (typeof event.preventDefault !== "undefined") event.preventDefault();
                    common(event);
                    if (typeof fn === "function") fn(false);
                    return false;
                };

                // common event handler (keyup, ok and cancel)
                common = function (event) {
                    self.hide();
                    self.unbind(document.body, "keyup", key);
                    self.unbind(btnReset, "focus", reset);
                    if (hasOK) self.unbind(btnOK, "click", ok);
                    if (hasCancel) self.unbind(btnCancel, "click", cancel);
                };

                // keyup handler
                key = function (event) {
                    var keyCode = event.keyCode;
                    if ((keyCode === keys.SPACE && !hasInput) || (hasInput && keyCode === keys.ENTER)) ok(event);
                    if (keyCode === keys.ESC && hasCancel) cancel(event);
                };

                // reset focus to first item in the dialog
                reset = function (event) {
                    if (hasInput) input.focus();
                    else if (!hasCancel || self.buttonReverse) btnOK.focus();
                    else btnCancel.focus();
                };

                // handle reset focus link
                // this ensures that the keyboard focus does not
                // ever leave the dialog box until an action has
                // been taken
                this.bind(btnReset, "focus", reset);
                this.bind(btnResetBack, "focus", reset);
                // handle OK click
                if (hasOK) this.bind(btnOK, "click", ok);
                // handle Cancel click
                if (hasCancel) this.bind(btnCancel, "click", cancel);
                // listen for keys, Cancel => ESC
                this.bind(document.body, "keyup", key);
                if (!this.transition.supported) {
                    this.setFocus();
                }
            },

            /**
             * Bind events to elements
             *
             * @param  {Object}   el       HTML Object
             * @param  {Event}    event    Event to attach to element
             * @param  {Function} fn       Callback function
             *
             * @return {undefined}
             */
            bind: function (el, event, fn) {
                if (typeof el.addEventListener === "function") {
                    el.addEventListener(event, fn, false);
                } else if (el.attachEvent) {
                    el.attachEvent("on" + event, fn);
                }
            },

            /**
             * Use alertify as the global error handler (using window.onerror)
             *
             * @return {boolean} success
             */
            handleErrors: function () {
                if (typeof global.onerror !== "undefined") {
                    var self = this;
                    global.onerror = function (msg, url, line) {
                        self.error("[" + msg + " on line " + line + " of " + url + "]", 0);
                    };
                    return true;
                } else {
                    return false;
                }
            },

            /**
             * Append button HTML strings
             *
             * @param {String} secondary    The secondary button HTML string
             * @param {String} primary      The primary button HTML string
             *
             * @return {String}             The appended button HTML strings
             */
            appendButtons: function (secondary, primary) {
                return this.buttonReverse ? primary + secondary : secondary + primary;
            },

            /**
             * Build the proper message box
             *
             * @param  {Object} item    Current object in the queue
             *
             * @return {String}         An HTML string of the message box
             */
            build: function (item) {
                var html = "",
                    type = item.type,
                    message = item.message,
                    css = item.cssClass || "";

                html += "<div class=\"alertify-dialog\">";
                html += "<a id=\"alertify-resetFocusBack\" class=\"alertify-resetFocus\" href=\"#\">Reset Focus</a>";

                if (_alertify.buttonFocus === "none") html += "<a href=\"#\" id=\"alertify-noneFocus\" class=\"alertify-hidden\"></a>";

                // doens't require an actual form
                if (type === "prompt") html += "<div id=\"alertify-form\">";

                html += "<article class=\"alertify-inner\">";
                html += dialogs.message.replace("{{message}}", message);

                if (type === "prompt") html += dialogs.input;

                html += dialogs.buttons.holder;
                html += "</article>";

                if (type === "prompt") html += "</div>";

                html += "<a id=\"alertify-resetFocus\" class=\"alertify-resetFocus\" href=\"#\">Reset Focus</a>";
                html += "</div>";

                switch (type) {
                    case "confirm":
                        html = html.replace("{{buttons}}", this.appendButtons(dialogs.buttons.cancel, dialogs.buttons.ok));
                        html = html.replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
                        break;
                    case "prompt":
                        html = html.replace("{{buttons}}", this.appendButtons(dialogs.buttons.cancel, dialogs.buttons.submit));
                        html = html.replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
                        break;
                    case "alert":
                        html = html.replace("{{buttons}}", dialogs.buttons.ok);
                        html = html.replace("{{ok}}", this.labels.ok);
                        break;
                    default:
                        break;
                }

                elDialog.className = "alertify alertify-" + type + " " + css;
                elCover.className = "alertify-cover";
                return html;
            },

            /**
             * Close the log messages
             *
             * @param  {Object} elem    HTML Element of log message to close
             * @param  {Number} wait    [optional] Time (in ms) to wait before automatically hiding the message, if 0 never hide
             *
             * @return {undefined}
             */
            close: function (elem, wait) {
                // Unary Plus: +"2" === 2
                var timer = (wait && !isNaN(wait)) ? +wait : this.delay,
                    self = this,
                    hideElement, transitionDone;

                // set click event on log messages
                this.bind(elem, "click", function () {
                    hideElement(elem);
                });
                // Hide the dialog box after transition
                // This ensure it doens't block any element from being clicked
                transitionDone = function (event) {
                    event.stopPropagation();
                    // unbind event so function only gets called once
                    self.unbind(this, self.transition.type, transitionDone);
                    // remove log message
                    elLog.removeChild(this);
                    if (!elLog.hasChildNodes()) elLog.className += " alertify-logs-hidden";
                };
                // this sets the hide class to transition out
                // or removes the child if css transitions aren't supported
                hideElement = function (el) {
                    // ensure element exists
                    if (typeof el !== "undefined" && el.parentNode === elLog) {
                        // whether CSS transition exists
                        if (self.transition.supported) {
                            self.bind(el, self.transition.type, transitionDone);
                            el.className += " alertify-log-hide";
                        } else {
                            elLog.removeChild(el);
                            if (!elLog.hasChildNodes()) elLog.className += " alertify-logs-hidden";
                        }
                    }
                };
                // never close (until click) if wait is set to 0
                if (wait === 0) return;
                // set timeout to auto close the log message
                setTimeout(function () {
                    hideElement(elem);
                }, timer);
            },

            /**
             * Create a dialog box
             *
             * @param  {String}   message        The message passed from the callee
             * @param  {String}   type           Type of dialog to create
             * @param  {Function} fn             [Optional] Callback function
             * @param  {String}   placeholder    [Optional] Default value for prompt input field
             * @param  {String}   cssClass       [Optional] Class(es) to append to dialog box
             *
             * @return {Object}
             */
            dialog: function (message, type, fn, placeholder, cssClass) {
                // set the current active element
                // this allows the keyboard focus to be resetted
                // after the dialog box is closed
                elCallee = document.activeElement;
                // check to ensure the alertify dialog element
                // has been successfully created
                var check = function () {
                    if ((elLog && elLog.scrollTop !== null) && (elCover && elCover.scrollTop !== null)) return;
                    else check();
                };
                // error catching
                if (typeof message !== "string") throw new Error("message must be a string");
                if (typeof type !== "string") throw new Error("type must be a string");
                if (typeof fn !== "undefined" && typeof fn !== "function") throw new Error("fn must be a function");
                // initialize alertify if it hasn't already been done
                this.init();
                check();

                queue.push({
                    type: type,
                    message: message,
                    callback: fn,
                    placeholder: placeholder,
                    cssClass: cssClass
                });
                if (!isopen) this.setup();

                return this;
            },

            /**
             * Extend the log method to create custom methods
             *
             * @param  {String} type    Custom method name
             *
             * @return {Function}
             */
            extend: function (type) {
                if (typeof type !== "string") throw new Error("extend method must have exactly one paramter");
                return function (message, wait) {
                    this.log(message, type, wait);
                    return this;
                };
            },

            /**
             * Hide the dialog and rest to defaults
             *
             * @return {undefined}
             */
            hide: function () {
                var transitionDone,
                    self = this;
                // remove reference from queue
                queue.splice(0, 1);
                // if items remaining in the queue
                if (queue.length > 0) this.setup(true);
                else {
                    isopen = false;
                    // Hide the dialog box after transition
                    // This ensure it doens't block any element from being clicked
                    transitionDone = function (event) {
                        event.stopPropagation();
                        // unbind event so function only gets called once
                        self.unbind(elDialog, self.transition.type, transitionDone);
                    };
                    // whether CSS transition exists
                    if (this.transition.supported) {
                        this.bind(elDialog, this.transition.type, transitionDone);
                        elDialog.className = "alertify alertify-hide alertify-hidden";
                    } else {
                        elDialog.className = "alertify alertify-hide alertify-hidden alertify-isHidden";
                    }
                    elCover.className = "alertify-cover alertify-cover-hidden";
                    // set focus to the last element or body
                    // after the dialog is closed
                    elCallee.focus();
                }
            },

            /**
             * Initialize Alertify
             * Create the 2 main elements
             *
             * @return {undefined}
             */
            init: function () {
                // ensure legacy browsers support html5 tags
                document.createElement("nav");
                document.createElement("article");
                document.createElement("section");
                // cover
                if ($("alertify-cover") == null) {
                    elCover = document.createElement("div");
                    elCover.setAttribute("id", "alertify-cover");
                    elCover.className = "alertify-cover alertify-cover-hidden";
                    document.body.appendChild(elCover);
                }
                // main element
                if ($("alertify") == null) {
                    isopen = false;
                    queue = [];
                    elDialog = document.createElement("section");
                    elDialog.setAttribute("id", "alertify");
                    elDialog.className = "alertify alertify-hidden";
                    document.body.appendChild(elDialog);
                }
                // log element
                if ($("alertify-logs") == null) {
                    elLog = document.createElement("section");
                    elLog.setAttribute("id", "alertify-logs");
                    elLog.className = "alertify-logs alertify-logs-hidden";
                    document.body.appendChild(elLog);
                }
                // set tabindex attribute on body element
                // this allows script to give it focus
                // after the dialog is closed
                document.body.setAttribute("tabindex", "0");
                // set transition type
                this.transition = getTransitionEvent();
            },

            /**
             * Show a new log message box
             *
             * @param  {String} message    The message passed from the callee
             * @param  {String} type       [Optional] Optional type of log message
             * @param  {Number} wait       [Optional] Time (in ms) to wait before auto-hiding the log
             *
             * @return {Object}
             */
            log: function (message, type, wait) {
                // check to ensure the alertify dialog element
                // has been successfully created
                var check = function () {
                    if (elLog && elLog.scrollTop !== null) return;
                    else check();
                };
                // initialize alertify if it hasn't already been done
                this.init();
                check();

                elLog.className = "alertify-logs";
                this.notify(message, type, wait);
                return this;
            },

            /**
             * Add new log message
             * If a type is passed, a class name "alertify-log-{type}" will get added.
             * This allows for custom look and feel for various types of notifications.
             *
             * @param  {String} message    The message passed from the callee
             * @param  {String} type       [Optional] Type of log message
             * @param  {Number} wait       [Optional] Time (in ms) to wait before auto-hiding
             *
             * @return {undefined}
             */
            notify: function (message, type, wait) {
                var log = document.createElement("article");
                log.className = "alertify-log" + ((typeof type === "string" && type !== "") ? " alertify-log-" + type : "");
                log.innerHTML = message;
                // append child
                elLog.appendChild(log);
                // triggers the CSS animation
                setTimeout(function () {
                    log.className = log.className + " alertify-log-show";
                }, 50);
                this.close(log, wait);
            },

            /**
             * Set properties
             *
             * @param {Object} args     Passing parameters
             *
             * @return {undefined}
             */
            set: function (args) {
                var k;
                // error catching
                if (typeof args !== "object" && args instanceof Array) throw new Error("args must be an object");
                // set parameters
                for (k in args) {
                    if (args.hasOwnProperty(k)) {
                        this[k] = args[k];
                    }
                }
            },

            /**
             * Common place to set focus to proper element
             *
             * @return {undefined}
             */
            setFocus: function () {
                if (input) {
                    input.focus();
                    input.select();
                } else btnFocus.focus();
            },

            /**
             * Initiate all the required pieces for the dialog box
             *
             * @return {undefined}
             */
            setup: function (fromQueue) {
                var item = queue[0],
                    self = this,
                    transitionDone;

                // dialog is open
                isopen = true;
                // Set button focus after transition
                transitionDone = function (event) {
                    event.stopPropagation();
                    self.setFocus();
                    // unbind event so function only gets called once
                    self.unbind(elDialog, self.transition.type, transitionDone);
                };
                // whether CSS transition exists
                if (this.transition.supported && !fromQueue) {
                    this.bind(elDialog, this.transition.type, transitionDone);
                }
                // build the proper dialog HTML
                elDialog.innerHTML = this.build(item);
                // assign all the common elements
                btnReset = $("alertify-resetFocus");
                btnResetBack = $("alertify-resetFocusBack");
                btnOK = $("alertify-ok") || undefined;
                btnCancel = $("alertify-cancel") || undefined;
                btnFocus = (_alertify.buttonFocus === "cancel") ? btnCancel : ((_alertify.buttonFocus === "none") ? $("alertify-noneFocus") : btnOK),
                    input = $("alertify-text") || undefined;
                form = $("alertify-form") || undefined;
                // add placeholder value to the input field
                if (typeof item.placeholder === "string" && item.placeholder !== "") input.value = item.placeholder;
                if (fromQueue) this.setFocus();
                this.addListeners(item.callback);
            },

            /**
             * Unbind events to elements
             *
             * @param  {Object}   el       HTML Object
             * @param  {Event}    event    Event to detach to element
             * @param  {Function} fn       Callback function
             *
             * @return {undefined}
             */
            unbind: function (el, event, fn) {
                if (typeof el.removeEventListener === "function") {
                    el.removeEventListener(event, fn, false);
                } else if (el.detachEvent) {
                    el.detachEvent("on" + event, fn);
                }
            }
        };

        return {
            alert: function (message, fn, cssClass) {
                _alertify.dialog(message, "alert", fn, "", cssClass);
                return this;
            },
            confirm: function (message, fn, cssClass) {
                _alertify.dialog(message, "confirm", fn, "", cssClass);
                return this;
            },
            extend: _alertify.extend,
            init: _alertify.init,
            log: function (message, type, wait) {
                _alertify.log(message, type, wait);
                return this;
            },
            prompt: function (message, fn, placeholder, cssClass) {
                _alertify.dialog(message, "prompt", fn, placeholder, cssClass);
                return this;
            },
            success: function (message, wait) {
                _alertify.log(message, "success", wait);
                return this;
            },
            error: function (message, wait) {
                _alertify.log(message, "error", wait);
                return this;
            },
            set: function (args) {
                _alertify.set(args);
            },
            labels: _alertify.labels,
            debug: _alertify.handleErrors
        };
    };

    // AMD and window support
    if (typeof define === "function") {
        define([], function () {
            return new Alertify();
        });
    } else if (typeof global.alertify === "undefined") {
        global.alertify = new Alertify();
    }

}(this));


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

// jQuery(document).ready(function(t) {

//     function o(l) {
//         return 11 === l.replace(/\D/g, "").length ? "(00) 00000-0000" : "(00) 0000-00009"
//     }
//     var a = null,
//         n = null,
//         s = null,
//         c = null,
//         r = null,
//         l = {
//             onKeyPress: function(l, e, i, t) {
//                 i.mask(o.apply({}, arguments), t)
//             }
//         };
//     t("#billing_cpf").mask("000.000.000-00"), t("#billing_postcode").mask("00000-000"), t("#billing_phone").mask(o, l), t("#billing_first_name").blur(function(l) {
//         var e = t(this).val().length;
//         a = e < 2 ? (t("#billing_first_name").css("border-color", "red"), 1) : (t("#billing_first_name").css("border-color", "#0f834d"), 0)
//     }), t("#billing_last_name").blur(function(l) {
//         var e = t(this).val().length;
//         n = e < 2 ? (t("#billing_last_name").css("border-color", "red"), 1) : (t("#billing_last_name").css("border-color", "#0f834d"), 0)
//     });
//     var i = function(l) {
//         if (0 < l.length && l.length < 14) return alertify.set({ delay: 1700 }), alertify.error("cpf inválido!"), t("#billing_cpf").css("border-color", "red"), t("#billing_cpf").val("").focus(), t("#billing_cpf").attr("placeholder", "Digite seu cpf vÃ¡lido"), void(s = 1);
//         14 === l.length && (s = valida_cpf_cnpj(l) ? (t("#billing_cpf").css("border-color", "#0f834d"), 0) : ( alertify.set({ delay: 1700 }), alertify.error("cpf inválido!"), t("#billing_cpf").css("border-color", "red"), t("#billing_cpf").val("").focus(), t("#billing_cpf").attr("placeholder", "CPF Inválido"), 1))
//     };
//     t("#billing_cpf").focusout(function(l) {
//         var e = t("#billing_cpf").val();
//         console.log("cpf digitado: " + e), i(e)
//     });
//     var e = function(l) {
//         c = l.length < 14 ? (t("#billing_phone").css("border-color", "red"), t("#billing_phone").val("").focus(), t("#billing_phone").attr("placeholder", "Telefone Inválido"), 1) : (t("#billing_phone").css("border-color", "#0f834d"), 0)
//     };
//     t("#billing_phone").change(function() {
//         var l = t("#billing_phone").val();
//         e(l)
//     });
//     var g = function(l, e) {
//             9 === e && t.get("https://viacep.com.br/ws/" + l + "/json", function(l) {
//                 if (1 == l.erro) return t("#billing_postcode").css("border-color", "red"), t("#billing_postcode").attr("placeholder", "Cep Inválido"), void t("#billing_postcode").val("").focus();
//                 b.go(l)
//             })
//         },
//         b = {
//             go: function(l) {
//                 t("#billing_postcode").css("border-color", "#0f834d"), t("#billing_address_1").val(l.logradouro), t("#billing_address_1").css("border-color", "#0f834d"), "" != t("#billing_number").val() && t("#billing_number").css("border-color", "#0f834d"), t("#billing_neighborhood").val(l.bairro), t("#billing_neighborhood").css("border-color", "#0f834d"), t("#billing_city").css("border-color", "#0f834d"), t("#billing_city").val(l.localidade), t("#billing_state option[value=" + l.uf + "]").prop("selected", !0), t("#select2-billing_state-container").attr("title", l.uf), t("#select2-billing_state-container").html(l.uf), t(".select2-selection--single").css("border-color", "#0f834d"), t("#billing_state option").each(function() {
//                     t(this).val() == l.uf && t(this).prop("selected", !0)
//                 }), r = 0, t("#billing_number").focus()
//             }
//         };
//     if (t("#billing_postcode").keyup(function(l) {
//             var e = t("#billing_postcode").val(),
//                 i = e.length;
//             9 === i && g(e, i)
//         }), 0 <= window.location.href.indexOf("finalizar-compra")) {
//         var d = t("#billing_first_name").val(),
//             p = t("#billing_first_name").val();
//         if (2 <= d.length && t("#billing_first_name").css("border-color", "#0f834d"), 2 <= p.length && t("#billing_last_name").css("border-color", "#0f834d"), "" != t("#billing_cpf").val()) {
//             var v = t("#billing_cpf").val();
//             i(v)
//         }
//         if ("" != t("#billing_postcode").val()) {
//             var u = t("#billing_postcode").val(),
//                 f = u.length;
//             g(u, f)
//         }
//         if ("" != t("#billing_phone").val()) {
//             var _ = t("#billing_phone").val();
//             e(_)
//         }
//         "" != t("#billing_email").val() && t("#billing_email").css("border-color", "#0f834d")
//     }
//     t(".button-tabs").click(function(l) {
//         l.preventDefault();
//         var e = t(this).attr("id");
//         switch (t(".tab-child").hide(), t("#" + e).show(), t(this).attr("data-tab")) {
//             case "tab-one":
//                 h.go(t(this).attr("data-tab"), "#btn-cart", "#btn-two"), t(".ball").removeClass("active"), t("#checkout-step1").addClass("active"), t("#icon-seta-step-left").css("display", "none"), t("#icon-seta-step-right").css("display", "inline-block"), t("#btn-two").removeClass("last-step");
//                 break;
//             case "tab-two":
//                 m.validate(t(this).attr("data-tab"), "#btn-one", "#btn-three"), t(".ball").removeClass("active"), t("#checkout-step1").addClass("active"), t("#checkout-step2").addClass("active");
//                 var i = "<p><strong>Endereço:</strong> " + t("#billing_address_1").val() + "</p> <p><strong>Número:</strong> " + t("#billing_number").val() + "</p> <p><strong>Bairro:</strong> " + t("#billing_neighborhood").val() + "</p> <p><strong>Cidade/UF:</strong> " + t("#billing_city").val() + "/" + t("#select2-billing_state-container").text() + "</p>";
//                 t("#local-de-entrega").html(i);
//                 break;
//             case "tab-three":
//                 h.go(t(this).attr("data-tab"), "#btn-two", "#btn-checkout"), t(".ball").removeClass("active"), t("#checkout-step1").addClass("active"), t("#checkout-step2").addClass("active"), t("#checkout-step3").addClass("active"), t("#icon-seta-step-right").css("display", "none"), t("#icon-seta-step-left").css("display", "inline-block"), t("#btn-two").addClass("last-step");
//                 break;
//             default:
//                 alertify.set({
//                     delay: 1700
//                 });
//                 alertify.error("Error!");
//         }
//     });
//     var h = {
//             go: function(l, e, i) {
//                 t(".tab-child").hide(), t("#" + l).show(), t("#checkout-step-buttons a").hide(), t(e).show().css("float", "left"), t(i).show().css("float", "right")
//             }
//         },
//         m = {
//             validate: function(l, e, i) {
//                 h.go(l, e, i),
//                 "loged" == t("#checkout-form").attr("data-status") ? (h.go(l, e, i), t("#checkout-step1").addClass("active"),
//                 t("#checkout-step2").addClass("active")) : 0 == a && 0 == n && 0 == s && 0 == c && 0 == r ? (h.go(l, e, i),
//                 t(".ball").removeClass("active"),
//                 t("#checkout-step1").addClass("active"),
//                 t("#checkout-step2").addClass("active")) : (h.go("tab-one", "#btn-cart", "#btn-two"),
//                 alertify.set({delay: 3200 }),
//                 alertify.error("Um ou mais campos estão incorretos!"),
//                 console.log({
//                     name: a,
//                     lastname: n,
//                     cpf: s,
//                     phone: c,
//                     cep: r
//                 }))
//             }
//         }
// });

jQuery(document).ready(function ($) {
    $("#checkout-form tr.woocommerce-shipping-totals > th").remove();
    $("#checkout-form input[type='radio']").css({ "opacity": "0" });
    

    $("#billing_number").attr('type', 'number');

});  