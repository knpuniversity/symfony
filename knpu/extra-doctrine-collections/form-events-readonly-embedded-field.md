# Form Events Readonly Embedded Field

 All right. I've got one last little form challenge for us, and that's this. All four of these genus scientists are already saved to the database. It's kind of cool that I can just change this from one user to another user, but it's also a little bit weird if I needed ... Why would I ever change a specific scientist view from one user to another user? If this user weren't studying this genus anymore, I might delete them and I could add a new user to it. I'll be able to change it, it's just a little odd.

 I want to update the interface, so that when I hit add new, I have drop down for user, but for existing ones that have been saved to the database, instead of a field we just print the user's email. Effectively, what I want to do is, I want to remove the user field if this genus scientist behind it is already saved to the database. To do that, open up the genus scientist embedded form. We're going to use a feature that I don't have to use often in Syfony, and that is Symfony Form Events.

 You see, as you go through the life cycle of a form, from the form being created, data being set on the form, the form being submitted, you can actually hook into that process. Data reform ...

 Did you actually commit the ...

 [inaudible 00:01:44] Push. Push right now. Yep.

 Hit add event listener and then use a class called formevents:: and use post set data. After that, say array this comma on post set data. This post set data is a constant for an event called form.postsetdata. As the documentation says, this is dispatched at the end of form::setdata, which is a fancy way of saying once the actual data behind this form is added to it ... In other words, once the genus scientist is added to the form when the form is being set up, it will call the on post set data function which is one that we're going to create right inside this class. Public function on post set data and this will receive a form event object which we'll call event.

 Hey Leanna? Hey Leanna? I had a question on the master branch.

 [inaudible 00:03:37]

 [inaudible 00:03:41]

 Inside of here, you can say if event get data. This form is always bound to a genus scientist object. That would return the genus scientist object behind this form or if this is a new form, then actually it won't have anything bound to it and that will be null. That's why we'll say if event arrow get data, and and event arrow get data arrow get ID. As long as there is a genus scientist bound to this form and it's been saved to the database, in other words it has an ID, let's unset the user field from this form. We can do that by saying form=eventgetform and then unsetform[user. This form is a form object, but you can treat it like an array and that means you can actually unset that field from it. Cool.

 The last thing we need to do is conditionally render this field. If we refresh right now, we're going to get a huge error that there's no user field inside of our template at line nine, which is the line where we print out the user property. Now we can wrap that in an if statement that says if genus scientistform.user is defined, then we'll print it [inaudible 00:05:33]. Just use a strong tag and print the user's e-mail address with genusscientistform.vars, which is something we've talked about in our form theme tutorial, .data which will be the genus scientist object, .user .email.

 In other words, find the genus scientist object behind this form, call and get user on it, and then call get email on it. Now if we refresh, it looks perfect. If I add a new one, it has the actual proper field. Awesome.
 
