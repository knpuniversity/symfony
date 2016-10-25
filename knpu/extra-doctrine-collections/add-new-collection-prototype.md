# Add New Collection Prototype

 What about adding a new scientist to this genus? Well, the way I want it work is I want to be able to have a new button called  Add New Scientist , and when I click it, it will give me a new blank form. When I fill that in and save, that will insert a new record into the genus scientist table. To do this we're going to need some Javascript and actually a little more advanced Javascript than just the little delete button.

 So, first up to get this to work, is to go to genus form type, and after allow delete, add another one called allow add, true. In the same way that allow delete tells this field that it's okay if one of the genus scientists is missing, that means it should be deleted, allow add says it's okay if there's an additional new genus scientist form being submitted. If there is, that should be a new genus scientist object.

 Next, go to the form template. I want to add a new link class equals j-s dash genus scientist dash add inside there. We'll give that a new class of f-a dash f-a dash plus circle. Then we'll say,  add another scientist . Perfect.

 Now, we'll start getting this hooked up in the edit template, adding another bit of Java script here, which says rapper dot on, click of the dot j-s dash genus scientist add, and we'll call this function, we'll start with the classic e dot net default.

 What are we going to do inside of this java script function exactly? Because, what I want to do is effectively clone one of these forms and insert a new, blank version of it right onto the page. So Symfony's collection type is something built into to do this called a prototype. Google for Symfony form collection and choose the  How to Embed a Collection of Forms  document. We're going to steal a little bit of code from this page.

 First, find the template under the new section and copy this data dash prototype attribute and head into our form template and add this to the rapper element. In fact, I'm going to make a new line here and then paste data dash prototype form underscroll widget, and we'll change this to genus form dot genus scientists, so a specific field we're working on, dot vars dot prototype.

 While we're here, there's one other thing that I know that we're going to need; and I'll explain it in a second. Add a data dash index set to genus form dot genus scientists pipe length, so that's going to be it. In index field, that's the number of fields that we have right now.

 So, without doing anything else, let's refresh the page and actually see what that looks like, because it's kind of confusing.

 Actually, you can see I have three  Add New Scientist s. Make sure to put that anchor tag inside of the for loop; that's what I meant to do. Perfect. Refresh again. There we go; that's a kind of looking better now.

 Also take out the ... There's like a space between there. All right, much better.

 If you search on the page and search for [gee-ay-uhs view-nus 05:20] scientist rapper, so if you check out the data dash prototype here, it looks crazy, but what this is, is actually a blank version of one of these embedded forms turned into html entities and put onto the attribute of this [dip 05:38]. The reason why I would do that is because now when we click this  Add Another Scientist , we're going to read this attribute and actually use it to clone into the page so that the user has a new form that they can fill out.

 Now one thing to notice on here is this underscore, underscore, name, underscore, underscore thing that appears in a couple of places. If you scroll up a little bit ... If you scroll down a little and look closely, you'll see that each of the forms has a different index number. You can see the first one is index zero and that appears in a couple different places, including the name attributes. The next one is one, and the next one is two.

 In the prototype, instead of putting a number there, like zero, one, or two, it puts this underscore, underscore, name, underscore, underscore, and it expects us via Javascript to change that to a unique name. So in this case, we'd want to change it to the number three so that it fits in right at the end of our form. I'll show you what I mean in and a little more about that in a second.

 A lot of the Javascript that we need for this is actually right here in the Symfony documentation. Find the  add a tag  form function, and we're just going to copy the inside of this and go to our edit dot html [twig 07:09], and we're going to paste it on our  on click .

 Now, collection holder here, change that to rapper. That's going to be the element that has the prototype on it, so this reads the prototype. It also reads that index property, which is important, because that tells us what number to use for the next one. [inaudible 00:07:44] down here, we actually increase the index, so we add another one. It uses the next one. Then, at the very bottom here, to actually put the form on a page, I'm going to say dollar sign, open parenthesis, this dot before new form, because this actually represents the link that was clicked. We'll put this right before the link.

 Now, notice the new form variable actually comes from reading the prototype and replacing underscore, underscore, name, underscore, underscore with the index. So, if we go back now, let's give this a try. Refresh the page, and there we go. We can hit  add another scientist . Now, the styling is not quite right yet, and we are going to fix that, but ignore that for now.

 If we add just one new scientist, let's say fifteen, hit save, it blows up. That shouldn't be a surprise, because if you scroll down a little bit, you can see that when we add a new scientist, it's called the  add genus scientist method  on our genus object. This is something that we haven't actually updated yet. It's still set up for our old many to many relationship, so let's update this. Genus scientist are in factor of this variable to be genus scientist. Actually, I'm not going to set up the owning site yet. We will need to in a second. We're going to do this one step at a time.

 With that fixed, we'll go back, I'll just refresh to resubmit the form, and we get a different error. This one's interesting.  A new entity was found through the relationship genus, genus scientists that was not configured to cascade persist operations. For entity, genus scientist , then a bunch of ugly names. What's happening here is in our control, we're persisting the genus. Doctrine is smart enough to see the new genus scientist is on the genus scientist array, so it realizes that in order to save the genus, it also needs to save that genus scientist. But, we never called  persist  on it.

 You remember, in normal circumstances, whenever we want something to save, we call e-m persist and then e-m flsuh. Since we never called e-m persist on this new genus scientist, Doctrine is telling us,  Hey, I'm not sure what you want me to do here.

 We could do some extra work to actually call persist on the genus scientist inside of a controller, or we can do something a little fancier. In genus, up the top on our relationship, after  orphan removal equals true , add  cascade equals curly brace double quotes  and then  persist . This says, when we persist a genus, automatically call persist on each of the genus scientists. So, if there's a new genus scientist in that array, it will automatically call persist on it.

 If we refresh now, we hit our last error, which we totally expected this one. Insert into genus scientist, so it's trying to insert the new genus scientist, but the genus ID is set to null. This is because the form makes it a genus scientist embedded form, the user field and your study field are being filled in, but nobody is ever setting the genus property on genus scientist. So, it's staying blank and it's trying to insert without that value. Effects for that, we already know what it is.

 Inside genus in the adder method, we just need to make sure that the owning side of the relationship is set. I'll copy the same comment that we used down in the remover, and we'll say genus scientist arrow set genus this. And that will take care of setting the owning site.

 Refresh one last time. This time it works. We have four genuses. That's about as complicated as you can get with this stuff. Now, before we move onto something else, you go back to simply slash genus, click into genus and click into a user and click the pencil icon. This form is still totally broken, because our user form is still built as if we have a many to many relationship over to genus. We could rebuild this in the exact same way that we just rebuilt the genus form, but I'm actually going to remove this field from that form. So in user edit form, I removed studied genuses. Also open up the user slash edit template, remove it there. Finally, open up the user class and go down and find the adder and the remover for study genuses and remove those.

 Now head back, refresh, this form is looking good again. Whether or not you want to build a collection form on the user form is up to you, but if you don't need it, then you don't need to have all of the extra code with the adders and removers on the user class. In fact, we always need to keep in mind that there's only one side of relationship that's ever required.

 In this case, the genus scientist is the owning side of the relationship. That means that even mapping the other side of the relationship, which is the user dot study genuses relation is optional. We don't have to map this unless we need it. Of course, we are using it here on the user showpage to [inaudible 00:14:33] where the genus was studied, but if you go a step further, if you don't need to actually modify anything on the inverse side, then you also don't need to have an adder and a remover. So, I'm making my user class very simple, I have the inverse side mapped. I have a get studied genuses map up, but I don't have a set studied genuses map or an add studied genus or a remove studied genus.
 
