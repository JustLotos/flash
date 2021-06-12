import Axios from "../../../../Plugins/Axios";
import {ApiRouter} from "../../../App/ApiRouter";
import {Deck} from "./Deck";

export default {
    async fetch() {
        return Axios.get(ApiRouter.getRouteByName('fetchDecks').path);
    },
    async add(deck: Deck) {
        return Axios.post(ApiRouter.getRouteByName('addDeck').path, deck);
    },
    async update(deck: Deck) {
        // @ts-ignore
        return Axios.put(ApiRouter.getRouteByName('updateDeck', { id: deck.getId() }).path, deck);
    },
    async delete(deck: Deck) {
        // @ts-ignore
        return Axios.delete(ApiRouter.getRouteByName('deleteDeck', { id: deck.getId() }).path);
    },
    async get(deck: Deck) {

        // @ts-ignore
        return Axios.get(ApiRouter.getRouteByName('getDeck', { id: deck.getId() }).path);
    }
};
