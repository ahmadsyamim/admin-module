<table id="tblAppendGrid{{ $row->field }}"></table>
<textarea class="hidden" name="{{ $row->field }}" id="input{{ $row->field }}">
    {{ old($row->field, $dataTypeContent->{$row->field} ?? '') }}
</textarea>
<hr>
<h2>Child Items</h2>
<hr>
<div id="childGrid"></div>

@once
    @push('javascript')
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery.appendgrid@2/dist/AppendGrid.js"></script>
    @endpush
@endonce

@push('javascript')
    <script>
        myAppendGridChild{{ $row->field }} = [];
        function updateChild(el) {
            var ex = myAppendGrid{{ $row->field }}.getAllValue();
            var html = "";
            $.each(ex, function( index, value ) {
                var childId = "tblAppendGridChild{{ $row->field }}"+index;
                if (value.title && !$('#'+childId).length) {
                    var childCol = [
                        {
                            display: "Content",
                            name: "content",
                            type: "textarea",
                            events: {
                                change: function(e) {
                                    update{{ $row->field }}(myAppendGrid{{ $row->field }},false);
                                }
                            }
                        }
                    ];
                    html = " <div><h3>"+value.title+"</h3><table id="+childId+"></table></div>";
                    $('#childGrid').append(html);
                    myAppendGridChild{{ $row->field }}[index] = new AppendGrid({
                        element: childId,
                        uiFramework: "bootstrap4",
                        iconFramework: "fontawesome5",
                        columns: childCol

                    });
                    if (value.child) {
                        var value_child = JSON.parse(value.child);
                        myAppendGridChild{{ $row->field }}[index].load(value_child);
                    }

                }
            });
        }
        function update{{ $row->field }}(el,child = true) {
            var values = el.getAllValue();
            $.each(values, function( index, value ) {
                if (value.title) {
                    var childId = "tblAppendGridChild{{ $row->field }}"+index;
                    if ($('#'+childId).length) {
                        var valuesChild = myAppendGridChild{{ $row->field }}[index].getAllValue();
                        value.child = JSON.stringify(valuesChild);
                    }
                }
            });
            $('#input{{ $row->field }}').val(JSON.stringify(values, null));
            myAppendGrid{{ $row->field }}.load(values);
            if (child) {
                updateChild(el);
            }
        }
        // Execute when `DOM ready`
        var events = {
            change: function(e) {
                update{{ $row->field }}(myAppendGrid{{ $row->field }});
                if (e.target.value) {
                    e.target.style.backgroundColor = "#99FF99";
                } else {
                    e.target.style.backgroundColor = null;
                }
            }
        };
        var columns = @json(isset($options->columns) ? $options->columns : []);
        columns.forEach(function(item, index, arr) {
            item.events = events;
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize appendGrid
            myAppendGrid{{ $row->field }} = new AppendGrid({
                element: "tblAppendGrid{{ $row->field }}",
                uiFramework: "bootstrap4",
                iconFramework: "fontawesome5",
                afterRowRemoved: function(caller, rowIndex) {
                    update{{ $row->field }}(myAppendGrid{{ $row->field }});
                },
                columns: columns

            });

            @if ((old($row->field, $dataTypeContent->{$row->field} ?? ''))) 
            myAppendGrid{{ $row->field }}.load(JSON.parse(@json(old($row->field, $dataTypeContent->{$row->field} ?? ''))));
            updateChild(myAppendGrid{{ $row->field }})
            @endif
        });
    </script>
@endpush
