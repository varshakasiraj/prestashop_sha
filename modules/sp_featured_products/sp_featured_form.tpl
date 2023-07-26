<form action="{$link->getAdminLink('AdminModules')}&configure=sp_featured_products" method="POST">
   <div>
        <input type="text" name="modules"/>
   </div>
   <div>
        <select id="products" name="products[]" multiple="true" >
        <option value='0'>- Search user -</option>
        </select>
    </div>
    <div>
        <input type="submit" title="submit" name="submit"/>
    </div>
</form>