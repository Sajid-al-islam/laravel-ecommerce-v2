<ul>
    @foreach($brands as $brand)
    <li>
        <label for="brand{{$brand->id}}">
            <input type="checkbox" onchange="change_brand()"
                id="brand{{$brand->id}}"
                value="{{$brand->id}}"
                {{ $query_brands ? is_numeric(array_search($brand->id, $query_brands)) ? 'checked' : '' : '' }}
                class="form-check-input me-2" name="selected_brands" />
            {{ $brand->name }}
        </label>
    </li>
    @endforeach
</ul>
