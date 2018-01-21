import { Selector } from "testcafe";

export default function (t) {
    return {
        /**
         * use the navbar to visit the 'Backend'-Page. 
         * @returns Promise for the Page-Object of 'Backend'-Page
         */
        async navigateToViaNavbar() {
            await t.click("#nav_backend > a");
            return {
                /**
                 * There is a Tab-View with "Ausstellungen", "Gemälde", "News". Via
                 * the chooseXYZ-Functions you can get the Page-Object for the choosen tab.
                 */
                tabs: {
                    /**
                     * Choose the Tab 'Ausstellungen' and get its Page-Object
                     * @returns Promise for the Page-Object
                     */
                    async chooseAusstellungen() {
                        await t.click("#tab_exhibitions > a");
                        return {
                            /**
                             * Check, if the exhibition with the given name is present on screen
                             * @param {*} name e.g. "Bilder 2018"
                             */
                            async checkAusstellungWirdAngezeigt(name) {
                                const text = await Selector("#exhibition_table_body").innerText;
                                await t.expect(text).contains(name)
                            },
                            /**
                             * Clicks the button to create a new exhibition (which will show a dialog)
                             * @returns Promise for the Page-Object of the 'Neue Ausstellung hinzufügen'-Dialog
                             */
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
                    /**
                     * Choose the Tab 'Gemälde' and get its Page-Object
                     * @returns Promise for the Page-Object
                     */
                    async chooseGemaelde() {
                        await t.click("#tab_pictures > a");
                        return {
                            async uploadGemaelde() {
                                console.log("upload gemaelde");
                            }
                        };
                    },
                    /**
                     * Choose the Tab 'News' and get its Page-Object
                     * @returns Promise for the Page-Object
                     */
                    async chooseNews() {

                    }
                }
            }
        }
    };
};


