<h2 class='text-center blue text-capitalize'>Record: Wins/Total</h2>
<div class="text-center red score-size-20 rank-size-30">
  <div class="row" v-for="(name, pcs) in percentage">
      <div class="col-md-offset-3 col-md-6 flex">
          <div class="text-left">
             @{{ name }} :
          </div>
          <div class="text-right">
             @{{ pcs['winPerc'] }}%
          </div>
      </div>
  </div>
</div>
