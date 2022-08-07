<template>
  <div>
    <div class="box custome-box">
      <div class="box__content">
        <h3>{{ trans('userpage.txt_enter_user_info') }}</h3>
        <div class="form-group">
          <input
            class="input-field input-credit-card"
            type="text"
            :placeholder="trans('userpage.txt_name_placeholder')"
            required
            v-model="name"
          />
        </div>
        <div class="form-group">
          <input type="tel" id="phone" class="col-md-8" />
          <span id="valid-msg" class="hide">✓ Valid</span>
          <span id="error-msg" class="hide"></span>
        </div>

        <!-- <vue-tel-input
          v-model="phone"
          v-on:onValidate="onValidate"
          v-bind="bindProps"
          type="number"
          style="color:black"
        ></vue-tel-input>-->

        <br />
        <div class="order-item__option checkbox--after">
          <input type="checkbox" id="check2" data-add-book="false" v-model="acceptTerm" />
          <label for="check2">{{ trans('userpage.txt_accept_policy') }}</label>
        </div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <div class="box__footer order-footer">
          <div class="order-footer__cards">
            <!-- <img src="/web_content/img/cards.png" alt="Cards@2x"> -->
          </div>
          <div class="order-footer__action">
            <button
              class="btn-secondary btn--large"
              @click="onBtnClick"
            >{{ trans('userpage.txt_get_result_btn') }}</button>
          </div>
        </div>
      </div>
    </div>
    <p></p>

    <loading
      :active.sync="loading"
      :can-cancel="false"
      :background-color="loadingSetting.backgroundColor"
      :is-full-page="true"
    >
      <slot name="before">
        <div class="vld-icon">
          <svg
            viewBox="0 0 38 38"
            xmlns="http://www.w3.org/2000/svg"
            width="100"
            height="100"
            stroke="#ff0000"
            style="display:block;margin:auto"
          >
            <g fill="none" fill-rule="evenodd">
              <g transform="translate(1 1)" stroke-width="2">
                <circle stroke-opacity="0.25" cx="18" cy="18" r="18" />
                <path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(112.315 18 18)">
                  <animateTransform
                    attributeName="transform"
                    type="rotate"
                    from="0 18 18"
                    to="360 18 18"
                    dur="0.8s"
                    repeatCount="indefinite"
                  />
                </path>
              </g>
            </g>
          </svg>
        </div>
        <!-- <h1 style="color:white">{{statusMessage}}</h1> -->
      </slot>
    </loading>
  </div>
</template>
<script>
import * as intlTelInput from "../../../js/intel_phone/intlTelInput.js";
import VueTelInput from "vue-tel-input";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      loadingSetting: {
        backgroundColor: "#000000"
      },
      statusMessage: "Uploading data...",
      phone: "",
      name: "",
      userIP: "",
      countryCode: "",
      bindProps: {
        defaultCountry: "",
        disabledFetchingCountry: false,
        disabled: false,
        disabledFormatting: false,
        placeholder: "Enter a phone number",
        required: true,
        enabledCountryCode: false,
        enabledFlags: true,
        preferredCountries: ["ES", "CN"],
        onlyCountries: [],
        ignoredCountries: [],
        autocomplete: "off",
        name: "telephone",
        maxLen: 25,
        wrapperClasses: "",
        inputClasses: "",
        dropdownOptions: {
          disabledDialCode: false
        },
        inputOptions: {
          showDialCode: true
        }
      },
      acceptTerm: true,
      phoneValid: false,
      iti: null
    };
  },
  components: {
    VueTelInput,
    Loading
  },
  computed: {
    ...mapGetters("TestData", ["loading"])
  },
  beforeRouteLeave(to, from, next) {
    //can go only order detail page!!!
    if (to.name == "user.test.order") {
      next();
    } else {
      next(false);
    }
  },
  mounted() {
    var input = document.querySelector("#phone"),
      errorMsg = document.querySelector("#error-msg"),
      validMsg = document.querySelector("#valid-msg");
    var errorMap = [
      "Invalid number",
      "Invalid country code",
      "Too short",
      "Too long",
      "Invalid number"
    ];
    // initialise plugin
    var parent = this;
    this.iti = intlTelInput(input, {
      initialCountry: "auto",
      geoIpLookup: function(callback) {
        $.get(
          "https://ipinfo.io/json?token=ec390afea81cee",
          function() {},
          "jsonp"
        ).always(function(resp) {
          console.log(resp);
          parent.countryCode = resp && resp.country ? resp.country : "";
          parent.userIP = resp && resp.ip ? resp.ip : "";
          console.log(parent.userIP);
          callback(parent.countryCode);
        });
      },
      preferredCountries: ["ES", "CN", "US"],
      utilsScript: "/intel_phone/js/utils.js?1549804213570"
    });

    var reset = function() {
      input.classList.remove("error");
      errorMsg.innerHTML = "";
      errorMsg.classList.add("hide");
      validMsg.classList.add("hide");
    };
    var tempIti = this.iti;
    // on blur: validate
    input.addEventListener("keyup", function() {
      reset();
      if (input.value.trim()) {
        if (tempIti.isValidNumber()) {
          this.phoneValid = true;
          console.log(this.phoneValid);
          validMsg.classList.remove("hide");
        } else {
          this.phoneValid = false;
          input.classList.add("error");
          var errorCode = tempIti.getValidationError();
          errorMsg.innerHTML = errorMap[errorCode];
          errorMsg.classList.remove("hide");
        }
      }
    });

    // on keyup / change flag: reset
    // input.addEventListener("change", reset);
    // input.addEventListener("keyup", reset);
  },
  methods: {
    ...mapActions("TestData", ["resetState", "upload"]),
    onValidate(obj) {
      // this.phoneValid = obj.isValid;
    },

    formatPhoneNumber(number) {
      //remove all space in it
      return number.replace(/\s+/g, "");
    },
    onBtnClick() {
      if (this.name == "") {
        alert("Please enter your name!");
        return;
      }
      if (!this.iti.isValidNumber()) {
        alert("Please enter correct phone number!");
        return;
      }
      if (!this.acceptTerm) {
        alert("Please accept our policy!");
        return;
      }
      var phoneNumber = this.formatPhoneNumber(this.iti.getNumber());
      console.log(this.userIP);
      this.upload({
        mobileNumber: phoneNumber,
        userName: this.name,
        userIP: this.userIP,
        country: this.countryCode
      })
        .then(token => {
          this.$router.push({
            name: "user.test.order",
            params: {
              token: token
            }
          });
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>
<style scope>
@import "../../../css/intlTelInput.css";
.custome-box {
  margin-top: 80px;
  width: 40%;
  margin-left: auto;
  margin-right: auto;
}
@media (max-width: 768px) {
  .custome-box {
    width: 80%;
  }
}
@media (max-width: 333px) {
  .custome-box {
    width: 90%;
  }
}
#error-msg {
  color: red;
  float: right;
}

.hide {
  display: none;
}
#valid-msg {
  color: #00c900;
  float: right;
}
</style>


