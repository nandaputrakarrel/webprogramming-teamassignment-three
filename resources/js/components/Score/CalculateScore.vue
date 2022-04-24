<template>
  <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        Calculate Your Score!
      </div>
      <div class="card-body">
          <b-form @submit.prevent="actionSubmit" class="p-2">
          <b-form-group
            id="groupQuiz"
            label="Nilai Quiz :"
            label-for="quiz"
            description="Enter the score of your quiz."
          >
            <b-form-input
              id="quiz"
              v-model="data.quiz"
              type="number"
              min=0
              max=100
              placeholder="Enter Quiz Score"
              @input="calculateOverall"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupTugas"
            label="Nilai Tugas :"
            label-for="tugas"
            description="Enter the score of your tugas."
          >
            <b-form-input
              id="tugas"
              v-model="data.tugas"
              type="number"
              min=0
              max=100
              placeholder="Enter Tugas Score"
              @input="calculateOverall"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupAbsensi"
            label="Nilai Absensi :"
            label-for="absensi"
            description="Enter the score of your absensi."
          >
            <b-form-input
              id="absensi"
              v-model="data.absensi"
              type="number"
              min=0
              max=100
              placeholder="Enter Absensi Score"
              @input="calculateOverall"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupPraktek"
            label="Nilai Praktek :"
            label-for="praktek"
            description="Enter the score of your praktek."
          >
            <b-form-input
              id="praktek"
              v-model="data.praktek"
              type="number"
              min=0
              max=100
              placeholder="Enter Praktek Score"
              @input="calculateOverall"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupUas"
            label="Nilai UAS :"
            label-for="uas"
            description="Enter the score of your UAS."
          >
            <b-form-input
              id="uas"
              v-model="data.uas"
              type="number"
              min=0
              max=100
              placeholder="Enter UAS Score"
              @input="calculateOverall"
              required
            ></b-form-input>
          </b-form-group>
        </b-form>

        <b-progress max=100 height="2rem" :variant="variant" show-progress animated>
          <b-progress-bar v-model="overall">
            <span>Your Final Score is <strong>{{ overallText }} </strong></span>
          </b-progress-bar>
        </b-progress>

      </div>
  </div>
</template>

<script>
import formatter from '../../formatter';

export default {
  data () {
      return {
        data: {
          quiz: 0,
          tugas: 0,
          absensi: 0,
          praktek: 0,
          uas: 0,
        },
        overall: 0,
        overallText: "D",
        variant: "danger"
      }
    },
  mounted () {

  },
  computed: {

  },
  methods: {
    calculateOverall() {
      this.overall = (Number(this.data.quiz) + Number(this.data.tugas) + Number(this.data.absensi) + Number(this.data.praktek) + Number(this.data.uas) ) / 5;
      if (this.overall <= 65) {
        this.overallText = "D"
        this.variant = "danger"
      } else if (this.overall <= 75) {
        this.overallText = "C"
        this.variant = "warning"
      } else if (this.overall <= 85) {
        this.overallText = "B"
        this.variant = "info"
      } else {
        this.overallText = "A"
        this.variant = "success"
      }
    }
  }
}
</script>

<style>

</style>