<template>
  <div class="main-content">
    <div class="row" v-if="loading">
      <div class="col-xs-4 col-xs-offset-4">
        <div class="alert text-center">
          <i class="fa fa-spin fa-refresh"></i>
          {{ trans('userpage.txt_loading') }}
        </div>
      </div>
    </div>
    <div class="main-content__container" v-if="!loading">
      <div class="payment__header">
        <h1 class="payment__title">{{ trans('userpage.txt_payment') }}</h1>
        <div class="payment__subtitle">{{ trans('userpage.txt_ssl_checkout') }}</div>
      </div>
      <div class="payment__container">
        <div class="payment__main">
          <div class="box payment__box">
            <div class="box__content">
              <span class="payment__total">
                <strong class="comparison__price">
                  $
                  <span>{{Math.floor(amount/100)}}</span>
                  <sup>.{{amount%100 >= 10 ? amount%100 : ('0' + amount%100)}}</sup>
                </strong>
              </span>
              <div
                class="payment-errors alert alert-dismissible alert-warning"
                v-if="stripeErrorMessage"
              >
                <button type="button" class="alert__close" data-dismiss="alert" aria-label="Close">
                  <span class="icon" aria-hidden="true">×</span>
                </button>
                <div class="message">
                  <span>{{stripeErrorMessage}}</span>
                </div>
              </div>

              <form
                id="payment-form"
                class="payment__form"
                accept-charset="UTF-8"
                data-remote="true"
                @submit.prevent="onPayMethod"
              >
                <input name="utf8" type="hidden" value="✓">
                <div class="form-row payment__form-card--full-with">
                  <div class="form-group">
                    <label for="credit-card-number">{{ trans('userpage.txt_card_number') }}</label>
                    <input
                      class="input-field input-credit-card"
                      id="credit-card-number"
                      type="text"
                      :placeholder="trans('userpage.txt_card_number_placeholder')"
                      required
                      v-model="card.number"
                    >
                  </div>
                </div>

                <div class="form-row payment__form-card-extra">
                  <div class="form-group">
                    <label for="credit-card-month">{{ trans('userpage.txt_month') }}</label>
                    <select id="date_month" v-model="exp_month">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="credit-card-year">{{ trans('userpage.txt_year') }}</label>
                    <select id="date_year" v-model="exp_year">
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="security-code">{{ trans('userpage.txt_cvc') }}</label>
                    <input
                      class="input-field"
                      id="security-code"
                      type="text"
                      :placeholder="trans('userpage.txt_cvc')"
                      required
                      v-model="card.cvc"
                    >
                  </div>
                </div>

                <div class="form-row payment__form-card--full-with">
                  <div class="form-group">
                    <label for="cardHolderName">{{ trans('userpage.txt_name_on_card') }}</label>
                    <input
                      class="input-field"
                      id="cardHolderName"
                      type="text"
                      :placeholder="trans('userpage.txt_name_on_card_placeholder')"
                      v-model="cardName"
                    >
                  </div>
                </div>

                <div class="form-row payment__form-card--full-with">
                  <div class="form-group">
                    <label for="email">{{ trans('userpage.txt_email') }}</label>
                    <input
                      class="input-field"
                      id="email"
                      name="email"
                      type="email"
                      :placeholder="trans('userpage.txt_email_placeholder')"
                      required
                      v-model="email"
                    >
                  </div>
                </div>

                <p class="text-font-color-light">{{ trans('userpage.txt_payment_detail_1') }}</p>
                <button class="btn-secondary btn--large">{{ trans('userpage.txt_get_result_btn') }}</button>
              </form>

              <div class="payment__cards">
                <img src="/web_content/img/cards.png" alt="Cards@2x">
              </div>
            </div>
          </div>
        </div>

        <div class="payment__info">
          <div class="payment__info-block">
            <img :src="item.eval_logo_img" alt="Result@2x">
            <h3>{{ trans('userpage.txt_payment_detail_2') }}</h3>
            <ul class="list-check">
              <li class="small-message">{{ trans('userpage.txt_payment_detail_3') }}</li>
              <li>{{ trans('userpage.txt_payment_detail_7') }}</li>
            </ul>
          </div>

          <div class="payment__info-block">
            <img src="/web_content/img/moneyback.svg" alt="Moneyback">
            <h3>{{ trans('userpage.txt_payment_detail_4') }}</h3>
            <ul class="list-check">
              <li>{{ trans('userpage.txt_payment_detail_5') }}</li>
            </ul>
            <div class="contact-us">
              <p class="contact-us__text">
                <i class="fa fa-user"></i>
                {{ trans('userpage.txt_payment_detail_6') }}
              </p>
              <div class="general__footer" style="margin-top: 4rem;">
                <!-- <img
                    src="/assets/contact-info/iqtestnow.org-02886635d68fab726e0535f8bda31b929664c719f130e83ad7c35e470eb7389c.png"
                    alt="Iqtestnow.org"
                >-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      card: {
        number: "",
        cvc: "",
        exp: ""
      },
      cardName: "",
      email: "",
      exp_month: "1",
      exp_year: "2019",
      stripeErrorMessage: null,
      stripePublishableKey: "pk_test_CjAL1lLM7cOoE5N19Xknwvx500QdoaeqPY",
      stripeCheck: false
    };
  },
  created() {},
  computed: {
    ...mapGetters("OrderData", ["item", "loading", "amount"])
  },
  methods: {
    ...mapActions("OrderData", ["stripeOrder"]),
    onPayMethod() {
      console.log("payment!");
      //validation
      this.createToken();
    },
    createToken() {
      window.Stripe.setPublishableKey(this.stripePublishableKey);
      this.card.exp = this.exp_month + "/" + this.exp_year;
      window.Stripe.createToken(this.card, (status, response) => {
        if (response.error) {
          this.stripeCheck = false;
          this.stripeErrorMessage = response.error.message;
          // eslint-disable-next-line
          console.error(response);
        } else {
          console.log(response);
          var token = response;
          this.stripeOrder(token.id)
            .then(result => {
              //alert("Payment success!\n You will get result on your phone!");
              this.$router.push({
                name: "user.test.result",
                params: { token: this.$route.params.token }
              });
            })
            .catch(error => {
              console.error(error);
              alert(error);
            });
        }
      });
    }
  }
};
</script>
<style scope>
.main-content__container {
  width: 100%;
  margin-right: auto;
  margin-left: auto;
  padding-left: 2.4rem;
  padding-right: 2.4rem;
}
.payment__box {
  margin-left: 10px;
}
</style>


