<h2 class='text-center blue text-capitalize'>Record: most losses</h2>
<div class="text-center red score-size-20 rank-size-30">
  <div class="row" v-for="(name, loss) in losses">
      <div class="col-md-offset-3 col-md-6 flex">
          <div class="text-left">
             @{{ name }} :
          </div>
          <div class="text-right">
             @{{ loss }}
          </div>
      </div>
  </div>
</div>
