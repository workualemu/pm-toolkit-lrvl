import { createPopper } from "@popperjs/core";

export default (userOptions = {}) => ({
    popperInstance: null,
    options: buildOptions(userOptions),
    isShowPopper: false,

    init() {
        queueMicrotask(() => {
            this.popperInstance = createPopper(
                this.$refs.popperRef,
                this.$refs.popperRoot,
                this.options
            );
        });

        this.$watch("isShowPopper", (val) => {
            if (val) {
                this.popperInstance.update();
            }
        });
    },
});

const buildOptions = (options) => ({
    placement: options.placement ?? "auto",
    strategy: options.strategy ?? "fixed",
    onFirstUpdate: options.onFirstUpdate ?? function () {},
    modifiers: [
        {
            name: "offset",
            options: {
                offset: [0, options.offset ?? 0],
            },
        },
    ].concat(options.modifiers ?? []),
});