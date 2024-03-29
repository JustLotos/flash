import Card from "../Card/Card";
import {DateHelper} from "../../../../Utils/DateHelper";

export default class Repeat {
    private readonly id: number;
    private readonly createdAt: string;
    private readonly updatedAt: string
    private readonly time: string;
    private readonly ratingScore: number;
    private readonly card: string;
    private readonly interval: number;

    constructor({id, createdAt, updatedAt, time, ratingScore, card, interval} = {}) {
        this.id = id;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
        this.time = time;
        this.ratingScore = ratingScore;
        this.card = card;
        this.interval = interval;
    }

    get getId(): number { return this.id }
    get getCard(): string { return this.card }
    get getCreatedAt() { return Date.parse(this.createdAt); }
    get getUpdatedAt(): string { return this.updatedAt; }
    get updatedAtFormatted(): string { return DateHelper.dateFormat(this.updatedAt); }
    get getTime(): string { return this.time; }
    get getInterval(): number { return this.interval;  }
    get getRatingScore(): number { return this.ratingScore; }

    public static parseJSON(data: any) {
        let repeatString: string = JSON.stringify(data);
        let parsedRepeat = JSON.parse(repeatString,function (key, value) {
            if (key === 'card')     { return (new Card(value)).getId()}
            if (key === 'interval') { return DateHelper.formatInterval(value); }
            return value;
        });
        return new Repeat(parsedRepeat);
    }
}