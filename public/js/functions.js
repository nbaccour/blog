function formAsObject($form) {
    let fields = {};
    $form
        .find(":input")
        .each(function () {
            // The selector will match buttons; if you want to filter
            // them out, check `this.tagName` and `this.type`; see
            // below
            const $this = $(this);
            if (this.name && (this.type !== "radio" || this.type === "radio" && $this.prop("checked") === true)) {
                let value = this.value;
                if (value === 'false') {
                    value = false;
                } else if (value === 'true') {
                    value = true;
                } else {
                    value = this.value;
                }

                fields[this.name] = value;
            }
        });

    return fields;
}