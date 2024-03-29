import {Deck} from "../Deck/Deck";
import Record from "./Records";
import Repeat from "../Repeat/Repeat";

export default class Card {
    private readonly id: number;
    private readonly label: string;
    private readonly deck: number;
    private readonly currentRepeatInterval: number;
    private readonly isReadyForLearn: boolean;
    private readonly nextRepeatDate: string;
    private readonly records: [Record] = [];
    private readonly repeats: [number] = [];

    // @ts-ignore
    constructor({id, deck, records, label, repeats, nextRepeatDate, currentRepeatInterval, isReadyForLearn} = {}) {
        this.id = id || 0;
        this.deck = deck || 0;
        this.records = records || [];
        this.label = label || id || '';
        this.repeats = repeats || [];
        this.currentRepeatInterval = currentRepeatInterval;
        this.nextRepeatDate = nextRepeatDate;
        this.isReadyForLearn = !!isReadyForLearn;
    }

    public getId(): number { return this.id }
    public getDeck(): number { return this.deck }
    public getCurrentRepeatInterval(): number { return this.currentRepeatInterval }
    public isReady(): boolean { return this.isReadyForLearn }
    public getNextRepeatDate(): string { return this.nextRepeatDate }
    public getLabel(): string { return this.label }
    public getRepeats(): [number] { return this.repeats }
    public getRecords(): [Record] { return this.records }

    get getFrontData(): string {
        let records = this.records.filter((record: Record) => record.isFront());
        if(records.length) {
            return records[0].getValue();
        }

        return '';
    }
    set getFrontData(value: string) {
        let records = this.records.filter((record: Record) => record.isFront());
        if(records.length) {
             records[0].setValue(value);
        }
    }
    get getBackData(): string {
        let records = this.records.filter((record: Record) => record.isBack());
        if(records.length) {
            return records[0].getValue();
        }
        return '';
    }
    set getBackData(value: string) {
        let records = this.records.filter((record: Record) => record.isBack());
        if(records.length) {
            records[0].setValue(value);
        }
    }


    public static parseJSON(data: any): Card {
        let cardString: string = JSON.stringify(data);
        let parsedCard = JSON.parse(cardString,function (key, value) {
            if (key === 'deck') {
                return (new Deck(value)).getId();
            }

            if (key === 'records') {
                let records = value.length ? value as Array<any> : [];
                return records.map(data => new Record(data))
            }

            if (key === 'repeats') {
                let repeats = value.length ? value as Array<any> : [];
                return repeats.map(data => new Repeat(data).getId);
            }

            return value;
        });

        return new Card(parsedCard);
    }
}