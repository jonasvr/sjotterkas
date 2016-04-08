<h2 class='text-center blue text-capitalize'>Record: past games</h2>
<div class="text-center red score-size-20 rank-size-30">
  <div class="row">
    <div v-for="match in matches">
      <div class="col-md-offset-1 col-md-4 col-xs-offset-2 col-xs-3 text-center text-capitalize">
          <div class="flex">
              <div class="text-left">
                  @{{ match.player1 }}:
              </div>
              <div class="text-right">
                   @{{ match.points_left }}
              </div>
          </div>
      </div>
      <div class=" col-md-2 col-xs-2 text-uppercase">
        vs
      </div>
      <div class=" col-md-4 col-xs-3  text-center text-capitalize">
          <div class="flex">
              <div class="text-left">
                  @{{ match.player2 }}:
              </div>
              <div class="text-right">
                   @{{ match.points_right }}
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
