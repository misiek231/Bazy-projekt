<template>
    <div class="mt-3">
        <v-date-picker
            :columns="$screens({ default: 1, lg: 2 })"
            :rows="$screens({ default: 1, lg: 2 })"
            :is-expanded="$screens({ default: true, lg: false })"
            is-range
            :value="null"
            @input="onInput"
            color="red"
            :disabled-dates="disabledDates"
        />

        <div class="d-flex justify-content-around mt-3" style="width: 100%">
            <p class="fw-bold">Ilość dni: {{days}}</p>
            <p class="fw-bold">Cena: {{priceCounted}}zł</p>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'
import { DateRange } from '../Types/DateRange';

@Component({})
export default class Calendar extends Vue {

    @Prop({default: null}) disabledDates: DateRange[]
    @Prop({default: null}) price: number

    private days: number = 0
    private priceCounted: number = 0

    //private attributes: any[];

    // created() {
    //     console.log('created');
    //     console.log(this.disabledDates);
    //
    //     this.attributes = [
    //         {
    //             key: 'today',
    //             highlight: true,
    //             dates: [
    //                 { start: new Date(2022, 4, 2), end: new Date(2022, 4, 5) },
    //                 { start: new Date(2022, 4, 15), span: 5 } // # of days
    //             ]
    //         }
    //     ]
    // }



    private onInput(value: DateRange): void {

        if (value) {
            this.days = (value.end.valueOf() - value.start.valueOf()) / (1000 * 60 * 60 * 24) + 1;
            this.priceCounted = this.price * this.days;
        }

        (document.getElementById('date-from') as HTMLFormElement).value = value.start.toISOString().split('T')[0];
        (document.getElementById('date-to') as HTMLFormElement).value = value.end.toISOString().split('T')[0];
    }

}
</script>
