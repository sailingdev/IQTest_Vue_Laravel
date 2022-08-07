<template>
  <div class="main-content__container">
    <div class="row" v-if="loading">
      <div class="col-xs-4 col-xs-offset-4">
        <div class="alert text-center">
          <i class="fa fa-spin fa-refresh"></i>
          {{ trans('userpage.txt_loading') }}
        </div>
      </div>
    </div>
    <div v-if="!loading">
      <div class="results__header">
        <h1 class="results__title">{{ trans('userpage.txt_well_done') }}</h1>
        <div
          class="results__subtitle"
          v-if="item.time != null"
        >You've completed your {{item.title}} in</div>
        <div class="box results__timer" v-if="item.time != null">
          <div class="box__content">
            <div class="timer">{{item.time | timeFormatMS}}</div>
          </div>
        </div>
        <div class="results__subtitle">{{trans('userpage.txt_order_detail_1')}} {{item.title}}</div>
      </div>
      <div class="results__container">
        <div class="box">
          <div class="box__header is-center">
            <h3 class="order__box-title">{{ trans('userpage.txt_order_detail') }}</h3>
          </div>
          <div class="box-content">
            <div class="order">
              <div class="order-items">
                <div class="order-item">
                  <div class="order-item__image">
                    <img :src="item.eval_logo_img" alt="Result@2x">
                  </div>
                  <div class="order-item__info">
                    <span
                      class="order-item__title"
                    >{{item.title}} {{trans('userpage.txt_evaluation')}}</span>
                    <span class="order-item__extra">{{ trans('userpage.txt_your_result') }}</span>
                  </div>
                </div>
                <div class="order-item">
                  <div class="order-item__image">
                    <img :src="item.cert_logo_img" alt="Certificate@2x">
                  </div>
                  <div class="order-item__info">
                    <span
                      class="order-item__title"
                    >{{trans('userpage.txt_order_detail_2')}} {{item.title}}</span>
                    <span class="order-item__extra">{{ trans('userpage.txt_order_detail_3') }}</span>
                  </div>
                </div>
                <div class="order-item" v-if="item.extra_price > 0">
                  <div class="order-item__image">
                    <img :src="item.extra_logo_img" alt="Pdf@2x">
                  </div>
                  <div class="order-item__info">
                    <span
                      class="order-item__title"
                    >{{ trans('userpage.txt_extra_pdf')}} {{item.title}}</span>
                    <span class="order-item__extra">{{ trans('userpage.txt_order_detail_4') }}</span>
                  </div>
                  <div class="order-item__price">
                    <div class="order-item__option checkbox--after">
                      <input
                        type="checkbox"
                        id="check1"
                        v-bind:checked="extra_pay"
                        @input="updateExtraYes"
                      >
                      <label
                        for="check1"
                      >{{trans('userpage.txt_order_detail_5')}} $ {{item.extra_price/100}}</label>
                    </div>
                    <div class="order-item__option checkbox--after">
                      <input
                        type="checkbox"
                        id="check2"
                        v-bind:checked="!extra_pay"
                        @input="updateExtraNo"
                      >
                      <label for="check2">{{trans('userpage.txt_no_thanks')}}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="order-summary">
                <span class="order-summary__total">Total</span>
                <div class="order-item__price">
                  <span class="order-item__value">
                    $
                    <span>{{Math.floor(amount/100)}}</span>
                    <sup>.{{amount%100 >= 10 ? amount%100 : ('0' + amount%100)}}</sup>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="box__footer order-footer">
            <div class="order-footer__cards">
              <img src="/web_content/img/cards.png" alt="Cards@2x">
            </div>
            <div class="order-footer__action">
              <button
                class="btn-secondary btn--large"
                @click="gotoPaymentPage"
              >{{trans('userpage.txt_get_result_btn')}}</button>
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
      image: "https://i.imgur.com/z7cCtle.jpg",
      name: "Stripe Payment",
      description: "",
      currency: "USD",
      extra_pay: false
    };
  },
  watch: {},
  components: {},
  created() {
    console.log(this.$route.params.token);
    this.fetchData(this.$route.params.token);
  },
  mounted() {},

  methods: {
    ...mapActions("OrderData", [
      "resetState",
      "fetchData",
      "setAmount",
      "stripeOrder",
      "setExtraPay"
    ]),
    onValidate() {
      console.log("abc");
    },
    updateExtraYes(e) {
      this.extra_pay = e.target.checked;
      if (this.extra_pay) {
        this.setAmount(this.item.initial_price + this.item.extra_price);
      } else {
        this.setAmount(this.item.initial_price);
      }
    },
    updateExtraNo(e) {
      this.extra_pay = !e.target.checked;
      if (this.extra_pay) {
        this.setAmount(this.item.initial_price + this.item.extra_price);
      } else {
        this.setAmount(this.item.initial_price);
      }
    },
    gotoPaymentPage() {
      this.setExtraPay(this.extra_pay);
      this.$router.push({
        name: "user.test.payment",
        params: { token: this.$route.params.token }
      });
    }
  },
  computed: {
    ...mapGetters("OrderData", ["item", "loading", "amount"])
  }
};
</script>
<style scope>
.main-content__container {
  width: 80%;
  margin: auto;
}
.has-error {
  border: 2px solid red;
  border-radius: 4px;
}
</style>
