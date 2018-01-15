import { Selector } from "testcafe";

export default function (t) {
    return {
        async navigateToViaNavbar() {
            await t.click("#nav_backend > a");
            return {
                tabs: {
                    async chooseAusstellungen() {
                        await t.click("#tab_exhibitions > a");
                        return {
                            async checkAusstellungWirdAngezeigt(name) {
                                const text = await Selector("#exhibition_table_body").innerText;
                                await t.expect(text).contains(name)
                            },
                            async clickNeueAustellung() {
                                await t.click("button.open_category_dialog");
                                return {
                                    async setTitel(value) {
                                        await t.typeText("#category_name", value);
                                    },
                                    async setBeschreibung(value) {
                                        await t.typeText("#category_description", value);
                                    },
                                    async clickAnlegen() {
                                        await t.click("body > div.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-front.ui-dialog-buttons.ui-draggable.ui-resizable > div.ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix > div > button:nth-child(1)");
                                    },
                                    async clickAbbrechen() {
                                        throw new Error("nicht implementiert");
                                    }
                                }
                            }
                        }
                    },
                    async chooseGemaelde() {
                        await t.click("#tab_pictures > a");
                        return {
                            async uploadGemaelde() {
                                console.log("upload gemaelde");
                            }
                        };
                    },
                    async chooseNews() {

                    }
                }
            }
        }
    };
};


