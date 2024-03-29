import { Action, getModule, Module, Mutation, VuexModule } from "vuex-module-decorators";
import {Store} from "../../../App/Store";
import Vue from "vue";
import Repeat from "./Repeat";
import {AppModule} from "../../../App/AppModule";
import RepeatService from "./RepeatService";

@Module({
    dynamic: true,
    store: Store,
    name: 'RepeatModule',
    namespaced: true
})
class VuexRepeat extends VuexModule {
    allIds = [];
    byId = {};

    public get repeats() { return this.byId; }
    public get repeatsById(): Array<number> { return this.allIds as Array<number> }
    // @ts-ignore

    public get repeatById(): (id: number) => Repeat {
        return (id) => this.byId[id] as Repeat
    }

    public get repeatsByCard() { return (id) => {
        let repeats = Object.values(this.byId).filter(value => {
            return value.card === id
        });
        return repeats.map((repeats: Repeat) => repeats.getId);
    }}

    @Mutation
    public FETCH(data: any) {
        data.forEach((dataItem: any)=>{
            let repeat: Repeat = Repeat.parseJSON(dataItem);
            // @ts-ignore
            Vue.set(this.byId, repeat.getId, repeat);
            // @ts-ignore
            if (!this.allIds.includes(repeat.getId)) {
                // @ts-ignore
                this.allIds.push(repeat.getId);
            }
        });
    }

    //
    // @Action({ rawError: true })
    // public async fetchCardsByDeck(deck: Deck): Promise<any> {
    //     AppModule.loading();
    //     const response  = await CardService.fetchCardsByDeck(deck);
    //     this.FETCH(response.data);
    //     AppModule.unsetLoading();
    //     return response.data;
    // }
    //

    // //
    // @Action({ rawError: true })
    // public async add(dto: CardByDeckDTO): Promise<any> {
    //     AppModule.loading();
    //     const response  = await CardService.add(dto);
    //     this.FETCH([ response.data ]);
    //     AppModule.unsetLoading();
    //     return response.data;
    // }
    //
    // @Action({ rawError: true })
    // public async update(card: Card): Promise<any> {
    //     AppModule.loading();
    //     console.log(card)
    //     const response  = await CardService.update(card);
    //     this.FETCH([response.data]);
    //     AppModule.unsetLoading();
    //     return response.data;
    // }
    //
    @Action({ rawError: true })
    public async delete(repeat: Repeat): Promise<any> {
        AppModule.loading();
        const response  = await RepeatService.delete(repeat);
        this.DELETE(repeat);
        AppModule.unsetLoading();
        return response.data;
    }

    @Mutation
    private DELETE(repeat: Repeat) {
        // @ts-ignore
        Vue.delete(this.byId, repeat.id);
        // @ts-ignore
        this.allIds.splice(this.allIds.indexOf(repeat.id), 1)
    }
    //
    // @Action({ rawError: true })
    // public async get(card: Card): Promise<any> {
    //     AppModule.loading();
    //     const response  = await CardService.get(card);
    //     this.FETCH([response.data]);
    //     AppModule.unsetLoading();
    //     return response.data;
    // }
}


export const RepeatModule = getModule(VuexRepeat);